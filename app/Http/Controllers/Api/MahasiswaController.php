<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Database\Seeders\MahasiswaSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    /**
     * Resolve the current workspace / ruang slug from request route.
     */
    protected function getRuang(Request $request): string
    {
        $ruang = $request->route('ruang');
        return !empty($ruang) ? trim((string) $ruang) : 'public';
    }

    /**
     * Resolve target Mahasiswa ID from route parameters or arguments.
     */
    protected function getTargetId(Request $request, ...$args): string
    {
        $id = $request->route('mahasiswa') ?? $request->route('id');
        if (!empty($id)) {
            return (string) $id;
        }

        foreach (array_reverse($args) as $arg) {
            if (!empty($arg) && (is_string($arg) || is_numeric($arg))) {
                return (string) $arg;
            }
        }

        return '';
    }

    /**
     * Display a listing of students with optional search & filter in the workspace.
     */
    public function index(Request $request): JsonResponse
    {
        $ruang = $this->getRuang($request);

        // Auto-seed sample records if workspace is newly accessed
        if (Mahasiswa::where('ruang', $ruang)->count() === 0) {
            MahasiswaSeeder::seedForRuang($ruang);
        }

        $query = Mahasiswa::where('ruang', $ruang);

        // Pencarian berdasarkan nama atau NIM
        if ($request->filled('q')) {
            $keyword = trim($request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nim', 'like', "%{$keyword}%");
            });
        }

        // Filter berdasarkan jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', 'like', '%' . trim($request->query('jurusan')) . '%');
        }

        // Filter berdasarkan angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', (int) $request->query('angkatan'));
        }

        $mahasiswa = $query->latest('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar mahasiswa',
            'ruang'   => $ruang,
            'total'   => $mahasiswa->count(),
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Store a newly created student in workspace storage.
     */
    public function store(Request $request): JsonResponse
    {
        $ruang = $this->getRuang($request);

        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string|max:255',
            'nim'      => [
                'required',
                'string',
                'max:50',
                Rule::unique('mahasiswas', 'nim')->where(fn ($q) => $q->where('ruang', $ruang)),
                'regex:/^[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}$/',
            ],
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2099',
        ], [
            'nama.required'     => 'Field nama wajib diisi.',
            'nim.required'      => 'Field NIM wajib diisi.',
            'nim.unique'        => "NIM sudah terdaftar di ruang '{$ruang}'. Gunakan NIM yang berbeda.",
            'nim.regex'         => 'Format NIM tidak valid. Contoh yang benar: A11.2024.15656 (Format: [Prodi].[Tahun].[Urut]).',
            'jurusan.required'  => 'Field jurusan wajib diisi.',
            'angkatan.required' => 'Field angkatan wajib diisi.',
            'angkatan.integer'  => 'Angkatan harus berupa angka (contoh: 2024).',
            'angkatan.min'      => 'Angkatan minimal tahun 2000.',
            'angkatan.max'      => 'Angkatan maksimal tahun 2099.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, silakan periksa input Anda.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['ruang'] = $ruang;

        $mahasiswa = Mahasiswa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'ruang'   => $ruang,
            'data'    => $mahasiswa,
        ], 201);
    }

    /**
     * Display the specified student in the workspace.
     */
    public function show(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mahasiswa = Mahasiswa::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data mahasiswa berhasil ditemukan',
            'ruang'   => $ruang,
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Update the specified student in the workspace.
     */
    public function update(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mahasiswa = Mahasiswa::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'     => 'sometimes|required|string|max:255',
            'nim'      => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('mahasiswas', 'nim')
                    ->where(fn ($q) => $q->where('ruang', $ruang))
                    ->ignore($mahasiswa->id),
                'regex:/^[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}$/',
            ],
            'jurusan'  => 'sometimes|required|string|max:100',
            'angkatan' => 'sometimes|required|integer|min:2000|max:2099',
        ], [
            'nama.required'     => 'Field nama wajib diisi jika disertakan.',
            'nim.required'      => 'Field NIM wajib diisi jika disertakan.',
            'nim.unique'        => "NIM sudah terdaftar pada mahasiswa lain di ruang '{$ruang}'.",
            'nim.regex'         => 'Format NIM tidak valid. Contoh yang benar: A11.2024.15656 (Format: [Prodi].[Tahun].[Urut]).',
            'jurusan.required'  => 'Field jurusan wajib diisi jika disertakan.',
            'angkatan.required' => 'Field angkatan wajib diisi jika disertakan.',
            'angkatan.integer'  => 'Angkatan harus berupa angka (contoh: 2024).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, silakan periksa input Anda.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $mahasiswa->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diperbarui',
            'ruang'   => $ruang,
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Remove the specified student from the workspace.
     */
    public function destroy(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mahasiswa = Mahasiswa::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => "Data mahasiswa '{$mahasiswa->nama}' berhasil dihapus dari ruang '{$ruang}'.",
            'ruang'   => $ruang,
        ], 200);
    }

    /**
     * Display the specified student by NIM in the workspace.
     */
    public function showByNim(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $nim = $request->route('nim');
        if (empty($nim)) {
            foreach (array_reverse($args) as $arg) {
                if (!empty($arg) && (is_string($arg) || is_numeric($arg))) {
                    $nim = (string) $arg;
                    break;
                }
            }
        }

        $mahasiswa = Mahasiswa::where('ruang', $ruang)->where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan NIM {$nim} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data mahasiswa berhasil ditemukan',
            'ruang'   => $ruang,
            'data'    => $mahasiswa,
        ], 200);
    }
}

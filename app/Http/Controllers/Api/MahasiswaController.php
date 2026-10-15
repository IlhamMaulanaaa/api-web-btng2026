<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of students with optional search & filter.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Mahasiswa::query();

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
            'total'   => $mahasiswa->count(),
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string|max:255',
            'nim'      => [
                'required',
                'string',
                'max:50',
                'unique:mahasiswas,nim',
                'regex:/^[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}$/',
            ],
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2099',
        ], [
            'nama.required'     => 'Field nama wajib diisi.',
            'nim.required'      => 'Field NIM wajib diisi.',
            'nim.unique'        => 'NIM sudah terdaftar di sistem. Gunakan NIM yang berbeda.',
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

        $mahasiswa = Mahasiswa::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data'    => $mahasiswa,
        ], 201);
    }

    /**
     * Display the specified student.
     */
    public function show(string $id): JsonResponse
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data mahasiswa berhasil ditemukan',
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'     => 'sometimes|required|string|max:255',
            'nim'      => [
                'sometimes',
                'required',
                'string',
                'max:50',
                'unique:mahasiswas,nim,' . $mahasiswa->id,
                'regex:/^[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}$/',
            ],
            'jurusan'  => 'sometimes|required|string|max:100',
            'angkatan' => 'sometimes|required|integer|min:2000|max:2099',
        ], [
            'nama.required'     => 'Field nama wajib diisi jika disertakan.',
            'nim.required'      => 'Field NIM wajib diisi jika disertakan.',
            'nim.unique'        => 'NIM sudah terdaftar pada mahasiswa lain.',
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
            'data'    => $mahasiswa,
        ], 200);
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => "Data mahasiswa '{$mahasiswa->nama}' berhasil dihapus.",
        ], 200);
    }

    /**
     * Display the specified student by NIM.
     */
    public function showByNim(string $nim): JsonResponse
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan NIM {$nim} tidak ditemukan.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data mahasiswa berhasil ditemukan',
            'data'    => $mahasiswa,
        ], 200);
    }
}

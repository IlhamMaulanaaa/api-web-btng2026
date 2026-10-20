<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Database\Seeders\MobilSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
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
     * Resolve target Mobil ID from route parameters or arguments.
     */
    protected function getTargetId(Request $request, ...$args): string
    {
        $id = $request->route('mobil') ?? $request->route('id');
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
     * Display a listing of cars with search & filtering in the student workspace.
     */
    public function index(Request $request): JsonResponse
    {
        $ruang = $this->getRuang($request);

        // Lazy auto-seed starter cars if the workspace is newly accessed
        if (Mobil::where('ruang', $ruang)->count() === 0) {
            MobilSeeder::seedForRuang($ruang);
        }

        $query = Mobil::where('ruang', $ruang);

        // Pencarian berdasarkan nama model atau merk mobil
        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('brand', 'like', "%{$keyword}%");
            });
        }

        // Filter berdasarkan brand/merk
        if ($request->filled('brand')) {
            $query->where('brand', trim((string) $request->query('brand')));
        }

        // Filter berdasarkan jenis transmisi (Manual, Matic, CVT)
        if ($request->filled('transmisi')) {
            $query->where('transmisi', trim((string) $request->query('transmisi')));
        }

        // Filter berdasarkan jenis bahan bakar (Bensin, Diesel, Hybrid, Listrik)
        if ($request->filled('bahan_bakar')) {
            $query->where('bahan_bakar', trim((string) $request->query('bahan_bakar')));
        }

        // Filter berdasarkan status ketersediaan (tersedia, sold)
        if ($request->filled('status')) {
            $query->where('status', trim((string) $request->query('status')));
        }

        // Filter berdasarkan tahun pembuatan
        if ($request->filled('tahun')) {
            $query->where('tahun', (int) $request->query('tahun'));
        }

        // Filter rentang harga minimal
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', (int) $request->query('harga_min'));
        }

        // Filter rentang harga maksimal
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', (int) $request->query('harga_max'));
        }

        $mobils = $query->latest('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar mobil',
            'ruang'   => $ruang,
            'total'   => $mobils->count(),
            'data'    => $mobils,
        ], 200);
    }

    /**
     * Store a newly created car in the student workspace.
     */
    public function store(Request $request): JsonResponse
    {
        $ruang = $this->getRuang($request);

        $validator = Validator::make($request->all(), [
            'nama'        => 'required|string|min:2|max:150',
            'brand'       => 'required|string|min:2|max:100',
            'harga'       => 'required|integer|min:10000000|max:10000000000',
            'tahun'       => 'required|integer|min:1990|max:2026',
            'transmisi'   => 'required|string|in:Manual,Matic,CVT',
            'bahan_bakar' => 'required|string|in:Bensin,Diesel,Hybrid,Listrik',
            'status'      => 'required|string|in:tersedia,sold',
            'foto'        => 'nullable|url|max:500',
        ], [
            'nama.required'        => 'Nama / model mobil wajib diisi.',
            'nama.min'             => 'Nama mobil minimal 2 karakter.',
            'brand.required'       => 'Brand / merk mobil wajib diisi.',
            'harga.required'       => 'Harga jual mobil wajib diisi.',
            'harga.integer'        => 'Harga jual mobil harus berupa angka dalam Rupiah.',
            'harga.min'            => 'Harga jual mobil minimal Rp 10.000.000.',
            'harga.max'            => 'Harga jual mobil maksimal Rp 10.000.000.000.',
            'tahun.required'       => 'Tahun pembuatan mobil wajib diisi.',
            'tahun.integer'        => 'Tahun perakitan mobil harus berupa angka tahun.',
            'tahun.min'            => 'Tahun pembuatan minimal tahun 1990.',
            'tahun.max'            => 'Tahun pembuatan maksimal tahun 2026.',
            'transmisi.required'   => 'Transmisi mobil wajib diisi (Pilihan: Manual, Matic, CVT).',
            'transmisi.in'         => 'Pilihan transmisi tidak valid. Pilih: Manual, Matic, atau CVT.',
            'bahan_bakar.required' => 'Bahan bakar mobil wajib diisi (Pilihan: Bensin, Diesel, Hybrid, Listrik).',
            'bahan_bakar.in'       => 'Pilihan bahan bakar tidak valid. Pilih: Bensin, Diesel, Hybrid, atau Listrik.',
            'status.required'      => 'Status mobil wajib diisi (Pilihan: tersedia, sold).',
            'status.in'            => 'Status unit tidak valid. Pilih: tersedia atau sold.',
            'foto.url'             => 'URL foto mobil harus berupa format URL tautan gambar yang valid (contoh: https://images.unsplash.com/...).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, silakan periksa input data mobil Anda.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['ruang'] = $ruang;

        // Berikan URL foto placeholder default jika siswa tidak mengisi foto
        if (empty($validated['foto'])) {
            $validated['foto'] = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=80';
        }

        $mobil = Mobil::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data mobil berhasil ditambahkan ke showroom',
            'ruang'   => $ruang,
            'data'    => $mobil,
        ], 201);
    }

    /**
     * Display the specified car in the student workspace.
     */
    public function show(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mobil = Mobil::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mobil) {
            return response()->json([
                'success' => false,
                'message' => "Data mobil dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data mobil berhasil ditemukan',
            'ruang'   => $ruang,
            'data'    => $mobil,
        ], 200);
    }

    /**
     * Update the specified car in the student workspace.
     */
    public function update(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mobil = Mobil::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mobil) {
            return response()->json([
                'success' => false,
                'message' => "Data mobil dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'        => 'sometimes|required|string|min:2|max:150',
            'brand'       => 'sometimes|required|string|min:2|max:100',
            'harga'       => 'sometimes|required|integer|min:10000000|max:10000000000',
            'tahun'       => 'sometimes|required|integer|min:1990|max:2026',
            'transmisi'   => 'sometimes|required|string|in:Manual,Matic,CVT',
            'bahan_bakar' => 'sometimes|required|string|in:Bensin,Diesel,Hybrid,Listrik',
            'status'      => 'sometimes|required|string|in:tersedia,sold',
            'foto'        => 'nullable|url|max:500',
        ], [
            'nama.required'        => 'Nama / model mobil tidak boleh kosong.',
            'brand.required'       => 'Brand / merk mobil tidak boleh kosong.',
            'harga.integer'        => 'Harga jual mobil harus berupa angka dalam Rupiah.',
            'harga.min'            => 'Harga jual mobil minimal Rp 10.000.000.',
            'harga.max'            => 'Harga jual mobil maksimal Rp 10.000.000.000.',
            'tahun.integer'        => 'Tahun perakitan mobil harus berupa angka.',
            'tahun.min'            => 'Tahun perakitan minimal tahun 1990.',
            'tahun.max'            => 'Tahun perakitan maksimal tahun 2026.',
            'transmisi.in'         => 'Pilihan transmisi tidak valid. Pilih: Manual, Matic, atau CVT.',
            'bahan_bakar.in'       => 'Pilihan bahan bakar tidak valid. Pilih: Bensin, Diesel, Hybrid, atau Listrik.',
            'status.in'            => 'Status unit tidak valid. Pilih: tersedia atau sold.',
            'foto.url'             => 'URL foto mobil harus berupa format URL tautan gambar yang valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, silakan periksa input data mobil Anda.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $mobil->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data mobil berhasil diperbarui',
            'ruang'   => $ruang,
            'data'    => $mobil,
        ], 200);
    }

    /**
     * Remove the specified car from the student workspace.
     */
    public function destroy(Request $request, ...$args): JsonResponse
    {
        $ruang = $this->getRuang($request);
        $id = $this->getTargetId($request, ...$args);

        $mobil = Mobil::where('ruang', $ruang)->where('id', $id)->first();

        if (!$mobil) {
            return response()->json([
                'success' => false,
                'message' => "Data mobil dengan ID {$id} tidak ditemukan di ruang '{$ruang}'.",
            ], 404);
        }

        $namaMobil = $mobil->nama;
        $mobil->delete();

        return response()->json([
            'success' => true,
            'message' => "Data mobil '{$namaMobil}' berhasil dihapus dari ruang '{$ruang}'.",
            'ruang'   => $ruang,
            'id'      => (int) $id,
        ], 200);
    }
}

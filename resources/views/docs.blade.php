<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Praktik API Mahasiswa - Kelas Web BTNG</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        pre, code, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white font-extrabold text-xl shadow-md shadow-indigo-100">
                    🎓
                </span>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">API Mahasiswa</h1>
                    <p class="text-xs text-slate-500 font-medium">Bahan Praktikum Kelas Web BTNG</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="/docs/api" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Buku Menu API (Scramble)</span>
                </a>
                <button onclick="resetDataSaya()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span id="navResetLabel">Reset Data Saya</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8">

        <!-- INTRO HERO -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-3xl p-6 sm:p-10 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="max-w-3xl space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur">
                    ✨ Panduan Mudah untuk Pemula
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Belajar Menghubungkan Web ke API (CRUD Mahasiswa)
                </h2>
                <p class="text-indigo-100 text-sm sm:text-base leading-relaxed">
                    Selamat datang di kelas! Di halaman ini, kalian akan belajar cara <strong>mengambil data mahasiswa</strong> untuk ditampilkan ke web, serta cara <strong>menambah, mengedit, dan menghapus data</strong> langsung lewat JavaScript.
                </p>
            </div>
        </div>

        <!-- LANGKAH 1: PILIH KOTAK LATIHAN PRIBADI -->
        <div class="bg-white rounded-2xl border-2 border-indigo-500/30 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 text-lg">
                    1
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                        Buat "Kamar Latihan" Pribadi Kamu
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Biar data latihanmu <strong>tidak terhapus atau tertukar</strong> dengan teman di sebelahmu, ketik nama panggilanmu atau NIM kamu di bawah ini:
                    </p>
                </div>
            </div>

            <!-- Input Box -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        👤
                    </span>
                    <input id="namaRuangInput" type="text" placeholder="Ketik nama panggilanmu (contoh: budi, siti, atau NIM kamu)"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-medium">
                </div>
                <button onclick="simpanKamar()" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-200 transition shrink-0 flex items-center justify-center gap-2">
                    <span>🚀 Pasang Kamar Saya</span>
                </button>
            </div>

            <!-- Active URL Card -->
            <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-4 sm:p-5 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-900">Link API Khusus Kamu Saat Ini:</span>
                    </div>
                    <span id="statusKamarText" class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-200 text-indigo-800">
                        Kamar Aktif: Umum (Public)
                    </span>
                </div>

                <div class="flex items-center gap-2 bg-white border border-indigo-200 rounded-xl p-2.5 sm:p-3">
                    <code id="activeApiUrl" class="text-xs sm:text-sm font-mono text-indigo-700 font-bold truncate flex-1 select-all">
                        {{ url('/') }}/api/mahasiswa
                    </code>
                    <button onclick="salinLinkKhusus(this)" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center gap-1 shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>Salin Link</span>
                    </button>
                </div>

                <p class="text-xs text-slate-500">
                    💡 <strong>Tips:</strong> Salin link di atas dan tempelkan ke dalam kode <code>fetch()</code> tugas webmu. Server sudah otomatis menyiapkan 11 data mahasiswa contoh di dalam kamarmu!
                </p>
            </div>
        </div>

        <!-- LANGKAH 2: CARA MENGGUNAKAN API (4 OPERASI DASAR CRUD) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 text-lg">
                    2
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                        4 Jurus Dasar CRUD (Siap Pakai di Web Kamu)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Pilih operasi yang sedang ingin kamu kerjakan di tugasmu:
                    </p>
                </div>
            </div>

            <!-- Tab Buttons -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1">
                <button onclick="pilihJurus('jurusGet')" id="tabBtn-jurusGet" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-indigo-600 text-white border-indigo-600 shadow-sm">
                    <span class="text-base">📖</span>
                    <div>
                        <div class="font-bold">1. Ambil Data</div>
                        <div class="text-[10px] font-normal opacity-90">Method GET</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusPost')" id="tabBtn-jurusPost" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">➕</span>
                    <div>
                        <div class="font-bold">2. Tambah Data</div>
                        <div class="text-[10px] font-normal text-slate-500">Method POST</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusPut')" id="tabBtn-jurusPut" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">✏️</span>
                    <div>
                        <div class="font-bold">3. Ubah Data</div>
                        <div class="text-[10px] font-normal text-slate-500">Method PUT</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusDelete')" id="tabBtn-jurusDelete" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">🗑️</span>
                    <div>
                        <div class="font-bold">4. Hapus Data</div>
                        <div class="text-[10px] font-normal text-slate-500">Method DELETE</div>
                    </div>
                </button>
            </div>

            <!-- KONTEN JURUS 1: GET -->
            <div id="jurusGet" class="jurus-panel bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>📖</span> Menampilkan Daftar Mahasiswa ke Halaman Web
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat halaman web pertama kali dibuka untuk menampilkan data ke dalam tabel atau kartu.</p>
                    </div>
                    <button onclick="salinKode('code-get', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-get">// Kode JavaScript untuk mengambil data</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 2: POST -->
            <div id="jurusPost" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>➕</span> Mengirim Data dari Form Tambah Mahasiswa
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat tombol "Simpan" di form formulir web kamu diklik.</p>
                    </div>
                    <button onclick="salinKode('code-post', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-post">// Kode JavaScript untuk mengirim data baru</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 3: PUT -->
            <div id="jurusPut" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>✏️</span> Mengubah / Mengedit Data Mahasiswa
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini untuk memperbarui data mahasiswa berdasarkan nomor ID-nya.</p>
                    </div>
                    <button onclick="salinKode('code-put', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-put">// Kode JavaScript untuk update data</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 4: DELETE -->
            <div id="jurusDelete" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>🗑️</span> Menghapus Data Mahasiswa
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat tombol icon tempat sampah / "Hapus" pada tabel diklik.</p>
                    </div>
                    <button onclick="salinKode('code-delete', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-delete">// Kode JavaScript untuk menghapus data</pre>
                </div>
            </div>

        </div>

        <!-- LANGKAH 3: COBA LANGSUNG DI HALAMAN INI (SIMULASI NYATA) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 text-lg">
                        3
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                            Uji Coba Langsung (Live Preview)
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Lihat bagaimana data mahasiswa di kamarmu tampil di layar:
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="ambilDataSekarang()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-100 transition flex items-center gap-1.5">
                        <span>▶️ Tarik Data Mahasiswa</span>
                    </button>
                    <button onclick="toggleTampilanHasil()" id="btnToggleTampilan" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                        Lihat JSON Mentah
                    </button>
                </div>
            </div>

            <!-- HASIL DALAM BENTUK KARTU (RAMAH ORANG AWAM) -->
            <div id="tampilanVisual" class="space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-500 px-1">
                    <span id="labelJumlahData">Menampilkan data mahasiswa bawaan...</span>
                    <span class="text-emerald-600 font-semibold">● Terhubung ke Server</span>
                </div>

                <div id="daftarKartuMahasiswa" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div class="p-6 text-center text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 col-span-full">
                        Klik tombol <strong>"▶️ Tarik Data Mahasiswa"</strong> di atas untuk melihat isi kamarmu.
                    </div>
                </div>
            </div>

            <!-- HASIL DALAM BENTUK JSON (UNTUK KEBUTUHAN DEBUG) -->
            <div id="tampilanJson" class="hidden space-y-2">
                <div class="bg-slate-950 rounded-xl p-4 max-h-72 overflow-auto">
                    <pre id="rawJsonPre" class="text-xs font-mono text-emerald-400 leading-relaxed">// Hasil respon JSON mentah akan muncul di sini...</pre>
                </div>
            </div>
        </div>

        <!-- BANTUAN DARURAT (TROUBLESHOOTING) -->
        <div class="bg-amber-50 rounded-2xl border border-amber-200 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">🚑</span>
                <div class="space-y-0.5">
                    <h4 class="font-bold text-amber-900 text-sm">Datamu Tidak Sengaja Terhapus Semua atau Berantakan?</h4>
                    <p class="text-xs text-amber-800">
                        Jangan panik! Klik tombol reset untuk mengembalikan 11 data mahasiswa contoh awal ke dalam kamarmu.
                    </p>
                </div>
            </div>
            <button onclick="resetDataSaya()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition shrink-0">
                🔄 Kembalikan Data Contoh
            </button>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500 mt-12">
        API Mahasiswa • Dibuat khusus untuk bahan praktikum siswa di Kelas Web BTNG (DNCC UDINUS)
    </footer>

    <!-- Logic Script -->
    <script>
        const HOST_URL = '{{ url('/') }}';
        let kamarAktif = localStorage.getItem('btng_kamar_siswa') || '';

        function bersihkanNamaKamar(str) {
            return (str || '').trim().replace(/[^a-zA-Z0-9_\-\.]/g, '');
        }

        function getUrlKamar() {
            if (!kamarAktif) {
                return `${HOST_URL}/api/mahasiswa`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(kamarAktif)}/mahasiswa`;
        }

        function getUrlReset() {
            if (!kamarAktif) {
                return `${HOST_URL}/api/reset`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(kamarAktif)}/reset`;
        }

        function updateTampilan() {
            const isDefault = !kamarAktif;
            const endpoint = getUrlKamar();

            // Status label & badge
            const statusBadge = document.getElementById('statusKamarText');
            if (statusBadge) {
                statusBadge.innerText = isDefault ? 'Kamar Aktif: Umum (Public)' : `Kamar Aktif: ${kamarAktif}`;
                statusBadge.className = isDefault
                    ? 'text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700'
                    : 'text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200';
            }

            const urlText = document.getElementById('activeApiUrl');
            if (urlText) urlText.innerText = endpoint;

            const input = document.getElementById('namaRuangInput');
            if (input && kamarAktif) input.value = kamarAktif;

            const navReset = document.getElementById('navResetLabel');
            if (navReset) {
                navReset.innerText = isDefault ? 'Reset Data' : `Reset (${kamarAktif})`;
            }

            perbaruiContohKode(endpoint);
        }

        function perbaruiContohKode(endpoint) {
            // Jurus 1: GET
            document.getElementById('code-get').innerText =
`// 1. Ambil daftar mahasiswa
fetch('${endpoint}')
  .then(response => response.json())
  .then(hasil => {
    console.log('Data diterima:', hasil.data);
    // Sekarang kamu bisa lakukan perulangan (loop) untuk menampilkan ke HTML:
    hasil.data.forEach(mhs => {
      console.log(mhs.nama + ' - ' + mhs.nim);
    });
  })
  .catch(error => console.error('Gagal mengambil data:', error));`;

            // Jurus 2: POST
            document.getElementById('code-post').innerText =
`// 2. Tambah mahasiswa baru
const mahasiswaBaru = {
  nama: 'Farhan Ramadhan',
  nim: 'A11.2024.19999',       // Format NIM: A11.Tahun.Nomor (Contoh: A11.2024.19999)
  jurusan: 'Teknik Informatika',
  angkatan: 2024
};

fetch('${endpoint}', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(mahasiswaBaru)
})
  .then(response => response.json())
  .then(hasil => {
    if (hasil.success) {
      alert('Berhasil menambah mahasiswa!');
    } else {
      alert('Gagal: ' + hasil.message);
    }
  });`;

            // Jurus 3: PUT
            document.getElementById('code-put').innerText =
`// 3. Ubah data mahasiswa (Ganti angka 1 dengan ID mahasiswa yang mau diedit)
const idTarget = 1;

fetch('${endpoint}/' + idTarget, {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    nama: 'Nama yang Sudah Diubah',
    jurusan: 'Sistem Informasi'
  })
})
  .then(response => response.json())
  .then(hasil => alert('Data berhasil diperbarui!'));`;

            // Jurus 4: DELETE
            document.getElementById('code-delete').innerText =
`// 4. Hapus mahasiswa (Ganti angka 1 dengan ID mahasiswa yang mau dihapus)
const idTarget = 1;

fetch('${endpoint}/' + idTarget, {
  method: 'DELETE'
})
  .then(response => response.json())
  .then(hasil => alert('Data mahasiswa berhasil dihapus!'));`;
        }

        function simpanKamar() {
            const inputVal = bersihkanNamaKamar(document.getElementById('namaRuangInput').value);
            if (!inputVal) {
                alert('Tolong ketik nama atau NIM kamu terlebih dahulu ya.');
                return;
            }
            kamarAktif = inputVal;
            localStorage.setItem('btng_kamar_siswa', kamarAktif);
            updateTampilan();
            ambilDataSekarang();
            alert(`Kamar '${kamarAktif}' aktif! Sekarang kamu punya kamar latihan sendiri.`);
        }

        function salinLinkKhusus(btn) {
            const url = getUrlKamar();
            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<span>Tersalin! ✓</span>';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
            });
        }

        function salinKode(elementId, btn) {
            const text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                const orig = btn.innerText;
                btn.innerText = 'Tersalin! ✓';
                setTimeout(() => { btn.innerText = orig; }, 2000);
            });
        }

        function pilihJurus(idTarget) {
            document.querySelectorAll('.jurus-panel').forEach(p => p.classList.add('hidden'));
            document.getElementById(idTarget).classList.remove('hidden');

            document.querySelectorAll('.jurus-btn').forEach(b => {
                b.className = 'jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50';
            });
            document.getElementById('tabBtn-' + idTarget).className = 'jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-indigo-600 text-white border-indigo-600 shadow-sm';
        }

        let modeJson = false;
        function toggleTampilanHasil() {
            modeJson = !modeJson;
            document.getElementById('tampilanVisual').classList.toggle('hidden', modeJson);
            document.getElementById('tampilanJson').classList.toggle('hidden', !modeJson);
            document.getElementById('btnToggleTampilan').innerText = modeJson ? 'Lihat Tampilan Kartu' : 'Lihat JSON Mentah';
        }

        async function ambilDataSekarang() {
            const container = document.getElementById('daftarKartuMahasiswa');
            const preJson = document.getElementById('rawJsonPre');
            const labelTotal = document.getElementById('labelJumlahData');

            container.innerHTML = '<div class="p-6 text-center text-slate-400 col-span-full">Mengambil data dari server...</div>';
            preJson.innerText = 'Mengambil data...';

            try {
                const res = await fetch(getUrlKamar());
                const data = await res.json();
                preJson.innerText = JSON.stringify(data, null, 2);

                if (data.success && data.data && data.data.length > 0) {
                    labelTotal.innerText = `Menampilkan ${data.data.length} mahasiswa di kamarmu`;
                    let html = '';
                    data.data.forEach(mhs => {
                        html += `
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-indigo-300 transition space-y-2">
                            <div class="flex items-start justify-between">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 font-mono">
                                    ID: ${mhs.id}
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium font-mono">${mhs.nim}</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-900 text-sm">${mhs.nama}</h5>
                                <p class="text-xs text-slate-500">${mhs.jurusan} (${mhs.angkatan})</p>
                            </div>
                        </div>`;
                    });
                    container.innerHTML = html;
                } else {
                    labelTotal.innerText = 'Kamar masih kosong';
                    container.innerHTML = '<div class="p-6 text-center text-slate-400 col-span-full">Belum ada data mahasiswa di kamar ini.</div>';
                }
            } catch (err) {
                container.innerHTML = `<div class="p-6 text-center text-rose-500 col-span-full">Gagal mengambil data: ${err.message}</div>`;
                preJson.innerText = 'Error: ' + err.message;
            }
        }

        async function resetDataSaya() {
            const nama = kamarAktif || 'Umum';
            if (!confirm(`Kembalikan data di kamar '${nama}' ke 11 data contoh awal?`)) {
                return;
            }

            try {
                const res = await fetch(getUrlReset(), { method: 'POST' });
                const hasil = await res.json();
                alert(hasil.message || 'Data berhasil dikembalikan ke kondisi awal!');
                ambilDataSekarang();
            } catch (err) {
                alert('Gagal mereset: ' + err.message);
            }
        }

        // Jalankan saat pertama kali dibuka
        document.addEventListener('DOMContentLoaded', () => {
            updateTampilan();
            ambilDataSekarang();
        });
    </script>
</body>
</html>

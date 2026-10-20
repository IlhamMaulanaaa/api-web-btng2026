<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Praktik API Showroom Mobil - Kelas Web BTNG</title>
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
                    🚗
                </span>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">API Showroom Mobil</h1>
                    <p class="text-xs text-slate-500 font-medium">Bahan Praktikum Kelas Web BTNG DNCC</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="/docs/api" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Buku Menu API (Scramble)</span>
                </a>
                <button onclick="resetDataSaya()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span id="navResetLabel">Reset Showroom Saya</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8">

        <!-- INTRO HERO -->
        <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="max-w-3xl space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur">
                    ✨ Panduan Mudah untuk Pemula
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Belajar Menghubungkan Web ke API (CRUD Showroom Mobil)
                </h2>
                <p class="text-indigo-100 text-sm sm:text-base leading-relaxed">
                    Selamat datang di kelas! Di halaman ini, kalian akan belajar cara <strong>mengambil data katalog mobil</strong> dengan foto HD dan harga Rupiah untuk ditampilkan ke web, serta cara <strong>menambah unit, mengubah harga & status sold, dan menghapus mobil</strong> langsung lewat JavaScript <code>fetch()</code>.
                </p>
            </div>
        </div>

        <!-- LANGKAH 1: PILIH KAMAR LATIHAN PRIBADI -->
        <div class="bg-white rounded-2xl border-2 border-indigo-500/30 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 text-lg">
                    1
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                        Buat "Kamar Showroom" Pribadi Kamu
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Biar unit mobil latihanmu <strong>tidak terhapus atau tertukar</strong> dengan teman di sebelahmu, ketik NIM UDINUS kamu atau nama panggilanmu di bawah ini:
                    </p>
                </div>
            </div>

            <!-- Input Box -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        🔑
                    </span>
                    <input id="namaRuangInput" type="text" placeholder="Ketik NIM kamu (contoh: A11.2024.15656) atau nama panggilan"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-medium">
                </div>
                <button onclick="simpanKamar()" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-200 transition shrink-0 flex items-center justify-center gap-2">
                    <span>🚀 Pasang Showroom Saya</span>
                </button>
            </div>

            <!-- Active URL Card -->
            <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-4 sm:p-5 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-900">Link API Showroom Khusus Kamu Saat Ini:</span>
                    </div>
                    <span id="statusKamarText" class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-200 text-indigo-800">
                        Kamar Aktif: Umum (Public)
                    </span>
                </div>

                <div class="flex items-center gap-2 bg-white border border-indigo-200 rounded-xl p-2.5 sm:p-3">
                    <code id="activeApiUrl" class="text-xs sm:text-sm font-mono text-indigo-700 font-bold truncate flex-1 select-all">
                        {{ url('/') }}/api/mobil
                    </code>
                    <button onclick="salinLinkKhusus(this)" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center gap-1 shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>Salin Link</span>
                    </button>
                </div>

                <p class="text-xs text-slate-500">
                    💡 <strong>Tips:</strong> Salin link di atas dan tempelkan ke dalam kode <code>fetch()</code> tugas webmu. Server sudah otomatis menyiapkan <strong>12 unit mobil contoh</strong> lengkap dengan foto HD di dalam showroom kamarmu!
                </p>
            </div>
        </div>

        <!-- LANGKAH 2: CARA MENGGUNAKAN API (4 JURUS DASAR CRUD) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 text-lg">
                    2
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">
                        4 Jurus Dasar CRUD Mobil (Siap Pakai di Web Kamu)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Pilih operasi yang sedang ingin kamu kerjakan di tugas web showroom-mu:
                    </p>
                </div>
            </div>

            <!-- Tab Buttons -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1">
                <button onclick="pilihJurus('jurusGet')" id="tabBtn-jurusGet" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-indigo-600 text-white border-indigo-600 shadow-sm">
                    <span class="text-base">📖</span>
                    <div>
                        <div class="font-bold">1. Ambil Katalog</div>
                        <div class="text-[10px] font-normal opacity-90">Method GET</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusPost')" id="tabBtn-jurusPost" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">➕</span>
                    <div>
                        <div class="font-bold">2. Tambah Mobil</div>
                        <div class="text-[10px] font-normal text-slate-500">Method POST</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusPut')" id="tabBtn-jurusPut" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">✏️</span>
                    <div>
                        <div class="font-bold">3. Ubah Harga / Status</div>
                        <div class="text-[10px] font-normal text-slate-500">Method PUT</div>
                    </div>
                </button>
                <button onclick="pilihJurus('jurusDelete')" id="tabBtn-jurusDelete" class="jurus-btn py-3 px-3 rounded-xl border-2 font-bold text-xs sm:text-sm text-left transition flex items-center gap-2.5 bg-white text-slate-700 border-slate-200 hover:bg-slate-50">
                    <span class="text-base">🗑️</span>
                    <div>
                        <div class="font-bold">4. Hapus Mobil</div>
                        <div class="text-[10px] font-normal text-slate-500">Method DELETE</div>
                    </div>
                </button>
            </div>

            <!-- KONTEN JURUS 1: GET -->
            <div id="jurusGet" class="jurus-panel bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>📖</span> Menampilkan Daftar Mobil ke Halaman Web
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat halaman web pertama kali dibuka untuk merender kartu galeri mobil lengkap dengan foto & harga Rupiah.</p>
                    </div>
                    <button onclick="salinKode('code-get', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-get">// Kode JavaScript untuk mengambil katalog mobil</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 2: POST -->
            <div id="jurusPost" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>➕</span> Mengirim Data dari Form Tambah Mobil
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat tombol "Simpan Mobil" di form formulir web kamu diklik.</p>
                    </div>
                    <button onclick="salinKode('code-post', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-post">// Kode JavaScript untuk mengirim data mobil baru</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 3: PUT -->
            <div id="jurusPut" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>✏️</span> Mengubah Harga atau Menandai Status "Sold"
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini untuk memperbarui harga atau status ketersediaan unit berdasarkan nomor ID-nya.</p>
                    </div>
                    <button onclick="salinKode('code-put', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-put">// Kode JavaScript untuk update data mobil</pre>
                </div>
            </div>

            <!-- KONTEN JURUS 4: DELETE -->
            <div id="jurusDelete" class="jurus-panel hidden bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>🗑️</span> Menghapus Unit Mobil dari Showroom
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">Gunakan kode ini saat tombol icon tempat sampah / "Hapus" pada kartu diklik.</p>
                    </div>
                    <button onclick="salinKode('code-delete', this)" class="text-xs font-semibold px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Salin Kode</button>
                </div>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto text-xs text-indigo-300">
                    <pre id="code-delete">// Kode JavaScript untuk menghapus data mobil</pre>
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
                            Uji Coba Langsung (Live Preview Showroom)
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Lihat bagaimana katalog mobil di kamarmu tampil nyata di layar:
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <select id="filterBrand" onchange="ambilDataSekarang()" class="text-xs rounded-xl border border-slate-300 px-3 py-2 bg-white text-slate-700 font-medium focus:ring-indigo-500">
                        <option value="">Semua Brand</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Honda">Honda</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Mitsubishi">Mitsubishi</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Wuling">Wuling</option>
                        <option value="Mazda">Mazda</option>
                        <option value="Daihatsu">Daihatsu</option>
                        <option value="BYD">BYD</option>
                    </select>

                    <select id="filterStatus" onchange="ambilDataSekarang()" class="text-xs rounded-xl border border-slate-300 px-3 py-2 bg-white text-slate-700 font-medium focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="sold">Sold</option>
                    </select>

                    <button onclick="ambilDataSekarang()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-100 transition flex items-center gap-1.5">
                        <span>▶️ Tarik Katalog</span>
                    </button>
                    <button onclick="toggleTampilanHasil()" id="btnToggleTampilan" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                        Lihat JSON Mentah
                    </button>
                </div>
            </div>

            <!-- HASIL DALAM BENTUK KARTU (RAMAH ORANG AWAM) -->
            <div id="tampilanVisual" class="space-y-4">
                <div class="flex items-center justify-between text-xs text-slate-500 px-1">
                    <span id="labelJumlahData">Menampilkan data showroom bawaan...</span>
                    <span class="text-emerald-600 font-semibold">● Terhubung ke Server</span>
                </div>

                <div id="daftarKartuMobil" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200 col-span-full">
                        Klik tombol <strong>"▶️ Tarik Katalog"</strong> di atas untuk memuat unit mobil.
                    </div>
                </div>
            </div>

            <!-- HASIL DALAM BENTUK JSON (UNTUK KEBUTUHAN DEBUG) -->
            <div id="tampilanJson" class="hidden space-y-2">
                <div class="bg-slate-950 rounded-xl p-4 max-h-80 overflow-auto">
                    <pre id="rawJsonPre" class="text-xs font-mono text-emerald-400 leading-relaxed">// Respon JSON mentah dari server akan muncul di sini...</pre>
                </div>
            </div>
        </div>

        <!-- BANTUAN DARURAT (TROUBLESHOOTING) -->
        <div class="bg-amber-50 rounded-2xl border border-amber-200 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">🚑</span>
                <div class="space-y-0.5">
                    <h4 class="font-bold text-amber-900 text-sm">Showroom Berantakan atau Semua Mobil Tidak Sengaja Terhapus?</h4>
                    <p class="text-xs text-amber-800">
                        Jangan panik! Klik tombol reset untuk mengembalikan 12 unit mobil contoh awal ke dalam kamarmu. Data teman lain aman 100%.
                    </p>
                </div>
            </div>
            <button onclick="resetDataSaya()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition shrink-0">
                🔄 Kembalikan 12 Mobil Contoh
            </button>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500 mt-12">
        API Showroom Mobil • Dibuat khusus untuk bahan praktikum siswa di Kelas Web BTNG (DNCC UDINUS)
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
                return `${HOST_URL}/api/mobil`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(kamarAktif)}/mobil`;
        }

        function getUrlReset() {
            if (!kamarAktif) {
                return `${HOST_URL}/api/reset`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(kamarAktif)}/reset`;
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(angka || 0);
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
`// 1. Ambil daftar mobil dari showroom
fetch('${endpoint}')
  .then(response => response.json())
  .then(hasil => {
    console.log('Total Mobil:', hasil.total);
    // Tampilkan setiap mobil ke kartu HTML:
    hasil.data.forEach(mobil => {
      console.log(mobil.nama + ' - Rp ' + mobil.harga.toLocaleString('id-ID'));
    });
  })
  .catch(error => console.error('Gagal mengambil data:', error));`;

            // Jurus 2: POST
            document.getElementById('code-post').innerText =
`// 2. Tambah mobil baru ke showroom
const mobilBaru = {
  nama: 'Toyota Yaris GR Sport',
  brand: 'Toyota',
  harga: 345000000,
  tahun: 2024,
  transmisi: 'CVT',              // Pilihan: Manual | Matic | CVT
  bahan_bakar: 'Bensin',          // Pilihan: Bensin | Diesel | Hybrid | Listrik
  status: 'tersedia',            // Pilihan: tersedia | sold
  foto: 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=80'
};

fetch('${endpoint}', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify(mobilBaru)
})
  .then(response => response.json())
  .then(hasil => {
    if (hasil.success) {
      alert('Mobil berhasil ditambahkan ke showroom!');
    } else {
      alert('Validasi Gagal: ' + hasil.message);
    }
  });`;

            // Jurus 3: PUT
            document.getElementById('code-put').innerText =
`// 3. Ubah harga atau status mobil (Ganti angka 1 dengan ID mobil)
const idTarget = 1;

fetch('${endpoint}/' + idTarget, {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    status: 'sold'   // Tandai sudah terjual!
  })
})
  .then(response => response.json())
  .then(hasil => alert('Status mobil berhasil diubah menjadi SOLD!'));`;

            // Jurus 4: DELETE
            document.getElementById('code-delete').innerText =
`// 4. Hapus mobil dari showroom (Ganti angka 1 dengan ID mobil)
const idTarget = 1;

fetch('${endpoint}/' + idTarget, {
  method: 'DELETE',
  headers: { 'Accept': 'application/json' }
})
  .then(response => response.json())
  .then(hasil => alert('Mobil berhasil dihapus dari showroom!'));`;
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
            alert(`Kamar '${kamarAktif}' aktif! Sekarang kamu punya kamar showroom latihan sendiri.`);
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
            const container = document.getElementById('daftarKartuMobil');
            const preJson = document.getElementById('rawJsonPre');
            const labelTotal = document.getElementById('labelJumlahData');

            container.innerHTML = '<div class="p-8 text-center text-slate-400 col-span-full">Mengambil data mobil dari server...</div>';
            preJson.innerText = 'Mengambil data...';

            let url = getUrlKamar();
            const brand = document.getElementById('filterBrand')?.value;
            const status = document.getElementById('filterStatus')?.value;
            const params = new URLSearchParams();
            if (brand) params.append('brand', brand);
            if (status) params.append('status', status);
            const queryString = params.toString();
            if (queryString) {
                url += '?' + queryString;
            }

            try {
                const res = await fetch(url);
                const data = await res.json();
                preJson.innerText = JSON.stringify(data, null, 2);

                if (data.success && data.data && data.data.length > 0) {
                    labelTotal.innerText = `Menampilkan ${data.data.length} mobil di showroom kamarmu`;
                    let html = '';
                    data.data.forEach(m => {
                        const isSold = m.status === 'sold';
                        const badgeColor = isSold ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800';
                        const fallbackImg = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=80';
                        const imgUrl = m.foto || fallbackImg;

                        html += `
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                            <div class="relative h-44 w-full bg-slate-100">
                                <img src="${imgUrl}" alt="${m.nama}" class="w-full h-full object-cover" onerror="this.src='${fallbackImg}'">
                                <div class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded-lg font-mono">
                                    ID: ${m.id}
                                </div>
                                <div class="absolute top-3 right-3 font-bold text-[10px] px-2.5 py-0.5 rounded-full ${badgeColor}">
                                    ${m.status.toUpperCase()}
                                </div>
                            </div>
                            <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                                        ${m.brand} • ${m.tahun}
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-base leading-tight mt-0.5">${m.nama}</h4>
                                    <p class="text-indigo-600 font-extrabold text-lg mt-1">${formatRupiah(m.harga)}</p>
                                </div>
                                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                    <span class="inline-flex items-center gap-1">⚙️ ${m.transmisi}</span>
                                    <span class="inline-flex items-center gap-1">⛽ ${m.bahan_bakar}</span>
                                </div>
                            </div>
                        </div>`;
                    });
                    container.innerHTML = html;
                } else {
                    labelTotal.innerText = 'Showroom kosong';
                    container.innerHTML = '<div class="p-8 text-center text-slate-400 col-span-full">Tidak ada mobil yang cocok dengan filter atau showroom masih kosong.</div>';
                }
            } catch (err) {
                container.innerHTML = `<div class="p-8 text-center text-rose-500 col-span-full">Gagal mengambil data: ${err.message}</div>`;
                preJson.innerText = 'Error: ' + err.message;
            }
        }

        async function resetDataSaya() {
            const nama = kamarAktif || 'Umum';
            if (!confirm(`Kembalikan data showroom di kamar '${nama}' ke 12 mobil contoh awal?`)) {
                return;
            }

            try {
                const res = await fetch(getUrlReset(), { method: 'POST' });
                const hasil = await res.json();
                alert(hasil.message || 'Showroom berhasil di-reset ke 12 unit mobil awal!');
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

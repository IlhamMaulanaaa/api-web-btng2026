<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Mahasiswa - Dokumentasi Kelas Web & Workspace Sandbox</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
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
<body class="bg-slate-900 text-slate-100 min-h-screen antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-500/20">
                    🎓
                </span>
                <div>
                    <h1 class="text-base font-bold text-white tracking-tight">API Mahasiswa</h1>
                    <p class="text-xs text-slate-400">Kelas Belajar Web & API Consumption</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="/docs/api" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white shadow-sm transition">
                    <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span>Scramble Docs</span>
                </a>
                <a href="/mahasiswa-api.postman_collection.json" download class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                    <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h2v2h-2v-2zm0-10h2v8h-2V6z"/></svg>
                    <span>Postman</span>
                </a>
                <button onclick="triggerReset()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-600/20 hover:bg-rose-600/30 text-rose-300 border border-rose-500/30 transition">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span id="navResetText">Reset Data</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- 🌟 STUDENT WORKSPACE GENERATOR (SANDBOX ISOLATION) -->
        <div class="rounded-2xl bg-gradient-to-r from-indigo-900/60 via-slate-800/90 to-purple-900/50 border-2 border-indigo-500/40 p-6 sm:p-7 shadow-xl space-y-5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        <span>🎒</span> Fitur Kelas Praktikum: Multi-Tenant Sandbox
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-white">
                        Ruang Praktik Mandiri Siswa (Workspace)
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300">
                        Setiap siswa dapat memiliki ruang API sendiri! Data yang Anda tambahkan, ubah, atau hapus di ruang ini <strong>tidak akan pernah bertabrakan</strong> atau terhapus oleh teman sekelas.
                    </p>
                </div>

                <!-- Active Workspace Status Badge -->
                <div class="bg-slate-900/80 border border-slate-700 rounded-xl p-3 flex items-center gap-3 shrink-0">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                    <div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Ruang Aktif:</div>
                        <div id="activeRuangBadge" class="text-sm font-mono font-bold text-emerald-300">public (Umum)</div>
                    </div>
                </div>
            </div>

            <!-- Workspace Input Form -->
            <div class="bg-slate-900/90 rounded-xl p-4 border border-slate-700/80 space-y-3">
                <div class="flex flex-col sm:flex-row gap-2">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            🔑
                        </span>
                        <input id="workspaceInput" type="text" placeholder="Masukkan NIM Anda (contoh: A11.2024.15656) atau Nama Ruang"
                               class="w-full pl-9 pr-3 py-2.5 rounded-lg bg-slate-800 border border-slate-600 text-white placeholder-slate-400 text-sm focus:outline-none focus:border-indigo-400 font-mono">
                    </div>
                    <button onclick="setWorkspaceFromInput()" class="px-5 py-2.5 rounded-lg text-sm font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-md transition flex items-center justify-center gap-2">
                        <span>🚀 Aktifkan Ruang Saya</span>
                    </button>
                    <button onclick="setPublicWorkspace()" class="px-4 py-2.5 rounded-lg text-sm font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition">
                        Gunakan Ruang Publik
                    </button>
                </div>

                <!-- Quick Examples Chips -->
                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 pt-1">
                    <span>💡 Contoh Cepat:</span>
                    <button onclick="selectQuickRuang('A11.2024.15656')" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 font-mono">A11.2024.15656</button>
                    <button onclick="selectQuickRuang('budi')" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 font-mono">budi</button>
                    <button onclick="selectQuickRuang('siti')" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 font-mono">siti</button>
                    <button onclick="selectQuickRuang('kelompok-1')" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 font-mono">kelompok-1</button>
                </div>
            </div>

            <!-- Active Endpoint Indicator Bar -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pt-1 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-semibold text-slate-300">Base URL Khusus Anda:</span>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-800 font-mono text-indigo-300 font-medium">
                        <span id="activeWorkspaceUrl">{{ url('/') }}/api/mahasiswa</span>
                        <button onclick="copyActiveUrl(this)" class="text-slate-400 hover:text-white p-0.5" title="Salin URL">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="testFetchGet()" class="px-3 py-1.5 rounded-lg bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-300 border border-emerald-500/30 font-semibold transition">
                        ⚡ Uji GET Ruang Ini
                    </button>
                    <button onclick="triggerReset()" class="px-3 py-1.5 rounded-lg bg-rose-600/20 hover:bg-rose-600/30 text-rose-300 border border-rose-500/30 font-semibold transition">
                        🔄 Reset Ruang Ini
                    </button>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="rounded-2xl bg-gradient-to-br from-indigo-950/70 via-slate-900 to-slate-900 border border-indigo-500/20 p-6 sm:p-8 relative overflow-hidden">
            <div class="relative z-10 max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    API Aktif • Mendukung 30+ Siswa Bersamaan (No CORS Block)
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Praktik Consume (GET) & Post (POST) Data Mahasiswa
                </h2>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    API ini dirancang khusus untuk pembelajaran frontend web. Siswa dapat berlatih mengambil data (GET), menampilkan daftar tabel/kartu, melakukan pencarian, serta mengirimkan formulir tambah mahasiswa baru (POST).
                </p>

                <!-- Base URL Display -->
                <div class="pt-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Base URL API yang Digunakan:</span>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-950/80 border border-slate-800 font-mono text-sm text-indigo-300">
                        <span id="baseUrlText">{{ url('/') }}/api/mahasiswa</span>
                        <button onclick="copyToClipboard(document.getElementById('baseUrlText').innerText, this)" class="text-slate-400 hover:text-white transition p-1" title="Salin URL">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Playground & Data Monitor -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Quick Live Tester -->
            <div class="lg:col-span-1 rounded-2xl bg-slate-800/60 border border-slate-700/60 p-5 space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
                        <h3 class="font-bold text-white text-sm flex items-center gap-2">
                            <span>⚡</span> Coba Langsung (Live Test)
                        </h3>
                        <span id="liveBadge" class="text-xs px-2 py-0.5 rounded bg-slate-700 text-slate-300 font-mono">Idle</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        Klik tombol di bawah untuk menguji respon API langsung dari ruang aktif Anda.
                    </p>

                    <div class="mt-4 space-y-2">
                        <button onclick="testFetchGet()" class="w-full py-2 px-3 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white transition flex items-center justify-center gap-2">
                            <span id="liveBtnGetText">GET /api/mahasiswa</span>
                        </button>
                        <button onclick="toggleQuickPostForm()" class="w-full py-2 px-3 rounded-lg text-xs font-semibold bg-slate-700 hover:bg-slate-600 text-slate-200 transition flex items-center justify-center gap-2">
                            <span>+ Form Uji POST Mahasiswa</span>
                        </button>
                    </div>

                    <!-- Quick POST Form (Hidden by default) -->
                    <form id="quickPostForm" onsubmit="testFetchPost(event)" class="hidden mt-4 p-3 bg-slate-900/90 rounded-xl border border-slate-700 space-y-2 text-xs">
                        <p class="font-bold text-slate-300">Simulasi Kirim Data Baru:</p>
                        <input id="postNama" type="text" placeholder="Nama Mahasiswa" required class="w-full px-2.5 py-1.5 rounded bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                        <input id="postNim" type="text" placeholder="NIM (contoh: A11.2024.99001)" required class="w-full px-2.5 py-1.5 rounded bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                        <input id="postJurusan" type="text" placeholder="Jurusan (contoh: Teknik Informatika)" required class="w-full px-2.5 py-1.5 rounded bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                        <input id="postAngkatan" type="number" placeholder="Angkatan (contoh: 2024)" required class="w-full px-2.5 py-1.5 rounded bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                        <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-500 font-semibold text-white rounded">Kirim POST</button>
                    </form>
                </div>

                <div class="pt-3 border-t border-slate-700/60 text-xs text-slate-400">
                    💡 <span class="text-slate-300">Tips Praktikum:</span> Siswa dapat mereset data di ruang masing-masing kapan saja tanpa mengganggu siswa lain.
                </div>
            </div>

            <!-- Live Output JSON Viewer -->
            <div class="lg:col-span-2 rounded-2xl bg-slate-950 border border-slate-800 p-4 flex flex-col">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 text-xs text-slate-400">
                    <span class="font-mono flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-700 inline-block"></span>
                        Response Preview (JSON)
                    </span>
                    <button onclick="copyToClipboard(document.getElementById('liveResponsePre').innerText, this)" class="hover:text-white transition">Salin JSON</button>
                </div>
                <div class="mt-3 flex-1 overflow-auto max-h-72">
                    <pre id="liveResponsePre" class="text-xs font-mono text-emerald-400 whitespace-pre leading-relaxed">// Klik "GET /api/..." untuk melihat respon nyata dari server...</pre>
                </div>
            </div>

        </div>

        <!-- Endpoints Specifications -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span>📚</span> Daftar Endpoint Lengkap (Mendukung Workspace)
            </h3>

            <div class="space-y-3">

                <!-- Endpoint 1: GET All -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">GET</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa</span>
                        </div>
                        <span class="text-xs text-slate-400">Ambil daftar mahasiswa di ruang aktif (Query: <code class="text-indigo-300">?q=nama&jurusan=TI&angkatan=2024</code>)</span>
                    </div>
                </div>

                <!-- Endpoint 2: GET by NIM -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">GET</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa/nim/{nim}</span>
                        </div>
                        <span class="text-xs text-slate-400">Pencarian langsung via NIM (contoh: <code class="text-emerald-300">A11.2024.15656</code>)</span>
                    </div>
                </div>

                <!-- Endpoint 3: GET Detail by ID -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">GET</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa/{id}</span>
                        </div>
                        <span class="text-xs text-slate-400">Ambil data detail 1 mahasiswa berdasarkan ID</span>
                    </div>
                </div>

                <!-- Endpoint 4: POST -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">POST</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa</span>
                        </div>
                        <span class="text-xs text-slate-400">Menambahkan data mahasiswa baru (Wajib: <code class="text-amber-300">nama, nim, jurusan, angkatan</code>)</span>
                    </div>
                    <div class="bg-slate-900/60 p-4 border-t border-slate-700/40 text-xs font-mono space-y-2">
                        <p class="text-slate-400 font-sans font-medium">Contoh Body JSON (POST):</p>
                        <pre class="text-slate-300">{
  "nama": "Farhan Ramadhan",
  "nim": "A11.2024.16999",
  "jurusan": "Teknik Informatika",
  "angkatan": 2024
}</pre>
                    </div>
                </div>

                <!-- Endpoint 5: PUT -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">PUT</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa/{id}</span>
                        </div>
                        <span class="text-xs text-slate-400">Memperbarui data mahasiswa (sebagian atau seluruh field)</span>
                    </div>
                </div>

                <!-- Endpoint 6: DELETE -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-rose-500/20 text-rose-400 border border-rose-500/30">DELETE</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/mahasiswa/{id}</span>
                        </div>
                        <span class="text-xs text-slate-400">Menghapus data mahasiswa dari ruang aktif</span>
                    </div>
                </div>

                <!-- Endpoint 7: RESET -->
                <div class="rounded-xl bg-slate-800/40 border border-slate-700/60 overflow-hidden">
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30">POST / GET</span>
                            <span class="font-mono text-sm font-semibold text-slate-200">/api/{ruang}/reset</span>
                        </div>
                        <span class="text-xs text-slate-400">Reset database ruang tersebut kembali ke 11 data awal bawaan seeder</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Code Snippets for Students -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span>💻</span> Contoh Kode untuk Siswa (URL Otomatis Sesuai Ruang Anda)
            </h3>

            <!-- Tab Buttons -->
            <div class="flex gap-2 border-b border-slate-800 pb-2">
                <button onclick="switchTab('snippetFetchGet')" id="tabBtn-snippetFetchGet" class="snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white">
                    1. Fetch (GET Consume)
                </button>
                <button onclick="switchTab('snippetFetchPost')" id="tabBtn-snippetFetchPost" class="snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300">
                    2. Fetch (POST Form)
                </button>
                <button onclick="switchTab('snippetAxios')" id="tabBtn-snippetAxios" class="snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300">
                    3. Axios (GET & POST)
                </button>
                <button onclick="switchTab('snippetError')" id="tabBtn-snippetError" class="snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300">
                    4. Tangkap Error 422
                </button>
            </div>

            <!-- Tab 1: Fetch GET -->
            <div id="snippetFetchGet" class="snippet-panel rounded-xl bg-slate-950 border border-slate-800 p-4 relative">
                <button onclick="copyToClipboard(document.getElementById('code-fetch-get').innerText, this)" class="absolute top-4 right-4 text-xs px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded border border-slate-700 transition">Salin Kode</button>
                <pre id="code-fetch-get" class="text-xs font-mono text-indigo-300 overflow-x-auto leading-relaxed">// 1. Mengambil data mahasiswa dengan fetch()</pre>
            </div>

            <!-- Tab 2: Fetch POST -->
            <div id="snippetFetchPost" class="snippet-panel hidden rounded-xl bg-slate-950 border border-slate-800 p-4 relative">
                <button onclick="copyToClipboard(document.getElementById('code-fetch-post').innerText, this)" class="absolute top-4 right-4 text-xs px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded border border-slate-700 transition">Salin Kode</button>
                <pre id="code-fetch-post" class="text-xs font-mono text-indigo-300 overflow-x-auto leading-relaxed">// 2. Mengirim data baru dengan fetch() POST</pre>
            </div>

            <!-- Tab 3: Axios -->
            <div id="snippetAxios" class="snippet-panel hidden rounded-xl bg-slate-950 border border-slate-800 p-4 relative">
                <button onclick="copyToClipboard(document.getElementById('code-axios').innerText, this)" class="absolute top-4 right-4 text-xs px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded border border-slate-700 transition">Salin Kode</button>
                <pre id="code-axios" class="text-xs font-mono text-indigo-300 overflow-x-auto leading-relaxed">// 3. Menggunakan Axios</pre>
            </div>

            <!-- Tab 4: Error Handling -->
            <div id="snippetError" class="snippet-panel hidden rounded-xl bg-slate-950 border border-slate-800 p-4 relative">
                <button onclick="copyToClipboard(document.getElementById('code-error').innerText, this)" class="absolute top-4 right-4 text-xs px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded border border-slate-700 transition">Salin Kode</button>
                <pre id="code-error" class="text-xs font-mono text-indigo-300 overflow-x-auto leading-relaxed">// 4. Cara Menampilkan Error Validasi di Form Siswa</pre>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 py-6 text-center text-xs text-slate-500">
        API Mahasiswa • Multi-Tenant Sandbox untuk Kelas Pemrograman Web & Organisasi Kampus
    </footer>

    <!-- Client-Side Scripts -->
    <script>
        const HOST_URL = '{{ url('/') }}';
        let currentRuang = localStorage.getItem('btng_mahasiswa_ruang') || 'public';

        function sanitizeRuang(str) {
            return (str || '').trim().replace(/[^a-zA-Z0-9_\-\.]/g, '');
        }

        function getActiveEndpoint() {
            if (!currentRuang || currentRuang === 'public') {
                return `${HOST_URL}/api/mahasiswa`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(currentRuang)}/mahasiswa`;
        }

        function getActiveResetEndpoint() {
            if (!currentRuang || currentRuang === 'public') {
                return `${HOST_URL}/api/reset`;
            }
            return `${HOST_URL}/api/${encodeURIComponent(currentRuang)}/reset`;
        }

        function updateUI() {
            const isPublic = !currentRuang || currentRuang === 'public';
            const endpoint = getActiveEndpoint();
            const resetEndpoint = getActiveResetEndpoint();

            // Update badge & texts
            const badge = document.getElementById('activeRuangBadge');
            if (badge) {
                badge.innerText = isPublic ? 'public (Umum)' : currentRuang;
                badge.className = isPublic
                    ? 'text-sm font-mono font-bold text-slate-300'
                    : 'text-sm font-mono font-bold text-emerald-300';
            }

            const urlDisplay = document.getElementById('activeWorkspaceUrl');
            if (urlDisplay) urlDisplay.innerText = endpoint;

            const baseUrlText = document.getElementById('baseUrlText');
            if (baseUrlText) baseUrlText.innerText = endpoint;

            const liveBtnText = document.getElementById('liveBtnGetText');
            if (liveBtnText) {
                liveBtnText.innerText = isPublic ? 'GET /api/mahasiswa' : `GET /api/${currentRuang}/mahasiswa`;
            }

            const navResetText = document.getElementById('navResetText');
            if (navResetText) {
                navResetText.innerText = isPublic ? 'Reset Data' : `Reset (${currentRuang})`;
            }

            const input = document.getElementById('workspaceInput');
            if (input && !isPublic) {
                input.value = currentRuang;
            }

            updateCodeSnippets(endpoint);
        }

        function updateCodeSnippets(endpoint) {
            // Snippet 1: Fetch GET
            document.getElementById('code-fetch-get').innerText =
`// 1. Mengambil data mahasiswa dengan fetch()
async function getMahasiswa() {
    try {
        const response = await fetch('${endpoint}', {
            headers: {
                'Accept': 'application/json'
            }
        });
        const result = await response.json();

        if (result.success) {
            console.log('Daftar Mahasiswa (Ruang: ' + (result.ruang || 'public') + '):', result.data);
            // Contoh loop data untuk dirender ke HTML:
            result.data.forEach(mhs => {
                console.log(\`\${mhs.nama} - \${mhs.nim} (\${mhs.jurusan})\`);
            });
        }
    } catch (error) {
        console.error('Gagal mengambil data:', error);
    }
}

// Panggil fungsi
getMahasiswa();`;

            // Snippet 2: Fetch POST
            document.getElementById('code-fetch-post').innerText =
`// 2. Mengirim data baru dengan fetch() POST
async function tambahMahasiswa(dataBaru) {
    try {
        const response = await fetch('${endpoint}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataBaru)
        });

        const result = await response.json();

        if (response.ok && result.success) {
            alert('Mahasiswa berhasil ditambahkan ke ruang Anda!');
            console.log('Data tersimpan:', result.data);
        } else {
            // Jika ada validasi gagal (Status 422)
            console.error('Validasi gagal:', result.errors);
            alert(result.message);
        }
    } catch (error) {
        console.error('Network Error:', error);
    }
}

// Contoh pemanggilan (NIM contoh UDINUS):
tambahMahasiswa({
    nama: 'Aulia Rahma',
    nim: 'A11.2024.99002',
    jurusan: 'Teknik Informatika',
    angkatan: 2024
});`;

            // Snippet 3: Axios
            document.getElementById('code-axios').innerText =
`// 3. Menggunakan Axios (CDN: <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"><\/script>)

// A. GET Mahasiswa
axios.get('${endpoint}')
    .then(response => {
        console.log(response.data.data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// B. POST Mahasiswa
axios.post('${endpoint}', {
    nama: 'Rian Pratama',
    nim: 'A11.2024.99003',
    jurusan: 'Sistem Informasi',
    angkatan: 2024
})
.then(response => {
    alert(response.data.message);
})
.catch(error => {
    if (error.response && error.response.status === 422) {
        console.log('Error Validasi:', error.response.data.errors);
    }
});`;

            // Snippet 4: Error handling
            document.getElementById('code-error').innerText =
`// 4. Cara Menampilkan Error Validasi di Form Siswa
// Format response saat status 422:
// {
//   "success": false,
//   "message": "Validasi gagal, silakan periksa input Anda.",
//   "errors": {
//     "nim": ["NIM sudah terdaftar di ruang Anda."],
//     "nama": ["Field nama wajib diisi."]
//   }
// }

function handleValidationErrors(errors) {
    document.querySelectorAll('.error-text').forEach(el => el.innerText = '');

    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = document.getElementById(\`error-\${field}\`);
        if (errorElement) {
            errorElement.innerText = messages[0];
        }
    }
}`;
        }

        function setWorkspaceFromInput() {
            const val = sanitizeRuang(document.getElementById('workspaceInput').value);
            if (!val) {
                alert('Silakan masukkan NIM atau nama ruang terlebih dahulu.');
                return;
            }
            currentRuang = val;
            localStorage.setItem('btng_mahasiswa_ruang', currentRuang);
            updateUI();
            testFetchGet(); // auto trigger test to show data
        }

        function selectQuickRuang(name) {
            currentRuang = sanitizeRuang(name);
            localStorage.setItem('btng_mahasiswa_ruang', currentRuang);
            updateUI();
            testFetchGet();
        }

        function setPublicWorkspace() {
            currentRuang = 'public';
            localStorage.setItem('btng_mahasiswa_ruang', 'public');
            const input = document.getElementById('workspaceInput');
            if (input) input.value = '';
            updateUI();
            testFetchGet();
        }

        function copyActiveUrl(btn) {
            copyToClipboard(getActiveEndpoint(), btn);
        }

        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerText = 'Tersalin! ✓';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            });
        }

        function switchTab(targetId) {
            document.querySelectorAll('.snippet-panel').forEach(p => p.classList.add('hidden'));
            document.getElementById(targetId).classList.remove('hidden');

            document.querySelectorAll('.snippet-tab-btn').forEach(b => {
                b.className = 'snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300';
            });
            document.getElementById('tabBtn-' + targetId).className = 'snippet-tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white';
        }

        function toggleQuickPostForm() {
            const form = document.getElementById('quickPostForm');
            form.classList.toggle('hidden');
        }

        async function testFetchGet() {
            const badge = document.getElementById('liveBadge');
            const pre = document.getElementById('liveResponsePre');
            badge.innerText = 'Fetching...';
            badge.className = 'text-xs px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono';

            const endpoint = getActiveEndpoint();

            try {
                const res = await fetch(endpoint, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                badge.innerText = `Status ${res.status}`;
                badge.className = 'text-xs px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono';
                pre.innerText = JSON.stringify(data, null, 2);
            } catch (err) {
                badge.innerText = 'Error';
                badge.className = 'text-xs px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 font-mono';
                pre.innerText = 'Error: ' + err.message;
            }
        }

        async function testFetchPost(e) {
            e.preventDefault();
            const badge = document.getElementById('liveBadge');
            const pre = document.getElementById('liveResponsePre');
            badge.innerText = 'Posting...';
            badge.className = 'text-xs px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono';

            const endpoint = getActiveEndpoint();

            const payload = {
                nama: document.getElementById('postNama').value,
                nim: document.getElementById('postNim').value,
                jurusan: document.getElementById('postJurusan').value,
                angkatan: parseInt(document.getElementById('postAngkatan').value, 10),
            };

            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                badge.innerText = `Status ${res.status}`;
                badge.className = res.ok ? 'text-xs px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono' : 'text-xs px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 font-mono';
                pre.innerText = JSON.stringify(data, null, 2);

                if (res.ok) {
                    alert('Sukses! Mahasiswa baru berhasil ditambahkan ke ruang aktif Anda.');
                }
            } catch (err) {
                badge.innerText = 'Error';
                badge.className = 'text-xs px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 font-mono';
                pre.innerText = 'Error: ' + err.message;
            }
        }

        async function triggerReset() {
            const ruangName = currentRuang || 'public';
            if (!confirm(`Apakah Anda yakin ingin me-reset data pada ruang '${ruangName}' kembali ke 11 data awal seeder?`)) {
                return;
            }

            const badge = document.getElementById('liveBadge');
            const pre = document.getElementById('liveResponsePre');
            badge.innerText = 'Resetting...';

            const resetEndpoint = getActiveResetEndpoint();

            try {
                const res = await fetch(resetEndpoint, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                badge.innerText = `Reset 200 OK`;
                badge.className = 'text-xs px-2 py-0.5 rounded bg-purple-500/20 text-purple-300 font-mono';
                pre.innerText = JSON.stringify(data, null, 2);
                alert(data.message || 'Database berhasil di-reset!');
            } catch (err) {
                alert('Gagal reset: ' + err.message);
            }
        }

        // Initialize UI on load
        document.addEventListener('DOMContentLoaded', () => {
            updateUI();
        });
    </script>
</body>
</html>

# 🎓 API Mahasiswa - Kelas Pemrograman Web

API sederhana dan siap pakai untuk materi **Consume (GET)** dan **Post (POST)** data mahasiswa. Didesain ramah untuk pemula dan dituning khusus agar **aman di-hit serentak oleh 30+ siswa** tanpa terhambat CORS atau rate limit.

Dilengkapi dengan:
* **Scramble Interactive API Documentation** di URL (`/docs/api` atau `/scramble`).
* **Halaman Web Dokumentasi & Live Tester** di root URL (`/`).
* **Koleksi Postman Siap Download** (`/mahasiswa-api.postman_collection.json`).
* **Fitur Darurat Reset Database** (`POST /api/reset`) untuk mengembalikan 11 data seeder awal jika data dirusak/dihapus siswa.

---

## ⚡ Fitur Anti-Macet untuk 30 Siswa Simultan

1. **Rate Limiting 1.000 req/menit:** Mencegah error `429 Too Many Requests` saat seluruh siswa di lab/kelas menggunakan WiFi dengan 1 IP publik yang sama (NAT).
2. **CORS Terbuka & Preflight Caching:** Mengizinkan request dari mana saja (`localhost`, `Live Server`, `file://`) dengan cache preflight `max_age = 86400` agar browser siswa tidak membebani server dengan request `OPTIONS` berulang kali.
3. **Validasi Regex NIM Standar Kampus:** Format wajib `A11.2024.15656` (`/^[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}$/`).
4. **Optimasi Concurrency Database:**
   * Di VPS: Direkomendasikan menggunakan **MySQL / MariaDB** (InnoDB row-level locking) agar request POST bersamaan tidak saling mengunci.
   * Di Lokal / SQLite: Otomatis mengaktifkan **WAL Mode** (Write-Ahead Logging) & busy timeout 5.000 ms.

---

## 📌 Daftar Endpoint

| Method | Endpoint | Keterangan | Materi Pembelajaran |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/mahasiswa` | List seluruh mahasiswa | **Consume (GET)** |
| **GET** | `/api/mahasiswa?q=budi` | Pencarian nama / NIM / jurusan | Filter & Search |
| **GET** | `/api/mahasiswa/nim/{nim}` | Cari mahasiswa via format NIM (`A11.2024.15656`) | Direct Lookup |
| **GET** | `/api/mahasiswa/{id}` | Detail 1 data mahasiswa | Consume Detail |
| **POST** | `/api/mahasiswa` | Tambah mahasiswa baru (Validasi NIM regex) | **Submit Form (POST)** |
| **PUT** | `/api/mahasiswa/{id}` | Update data mahasiswa | Update Data |
| **DELETE**| `/api/mahasiswa/{id}` | Hapus data mahasiswa | Delete Data |
| **POST / GET**| `/api/reset` | Reset data ke 11 mahasiswa seeder | **Fitur Darurat Pengajar** |

---

## 💻 Contoh Penggunaan di Frontend Siswa

### 1. Consume Data (GET dengan `fetch`)
```javascript
async function getMahasiswa() {
  try {
    const response = await fetch('http://IP_ATAU_DOMAIN_VPS/api/mahasiswa');
    const result = await response.json();

    if (result.success) {
      console.log('Data Mahasiswa:', result.data);
      // Tampilkan data ke tabel atau kartu HTML
    }
  } catch (error) {
    console.error('Gagal mengambil data:', error);
  }
}

getMahasiswa();
```

### 2. Kirim Data Baru (POST dengan `fetch`)
```javascript
async function simpanMahasiswa(dataBaru) {
  try {
    const response = await fetch('http://IP_ATAU_DOMAIN_VPS/api/mahasiswa', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(dataBaru)
    });

    const result = await response.json();

    if (response.ok && result.success) {
      alert('Berhasil: ' + result.message);
    } else {
      // Menangani error validasi (Status 422)
      console.error('Validasi gagal:', result.errors);
      alert(result.message);
    }
  } catch (error) {
    console.error('Network Error:', error);
  }
}

// Panggil fungsi
simpanMahasiswa({
  nama: 'Farhan Ramadhan',
  nim: 'A11.2024.16999',
  jurusan: 'Teknik Informatika',
  angkatan: 2024
});
```

---

## 🚀 Panduan Menjalankan di Komputer Lokal

```bash
# 1. Masuk ke direktori
cd api-web

# 2. Jalankan migrasi dan seeder
php artisan migrate --seed

# 3. Jalankan server lokal
php artisan serve
```
Buka browser di `http://127.0.0.1:8000` untuk melihat dokumentasi interaktif dan live tester.

---

## 🌐 Panduan Deploy ke VPS (Yang Sudah Ada Laravel)

Karena di VPS Anda sudah ada project Laravel yang berjalan, PHP dan Composer sudah terpasang. Anda cukup menambahkan site baru.

### Langkah 1: Upload / Clone ke VPS
Clone repositori atau copy folder project ke direktori web VPS (misal `/var/www/api-mahasiswa`):
```bash
cd /var/www
git clone <URL_REPO_ANDA> api-mahasiswa
cd api-mahasiswa
```

### Langkah 2: Install Dependensi & Setup `.env`
```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Sesuaikan file `.env` di VPS:
```ini
APP_NAME="API Mahasiswa"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://api-kelas.domain-anda.com

# Opsi 1: Menggunakan MySQL (Direkomendasikan untuk 30 siswa)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_api_mahasiswa
DB_USERNAME=user_mysql
DB_PASSWORD=password_mysql

# ATAU Opsi 2: Menggunakan SQLite (Jika tidak ingin buat database baru)
# DB_CONNECTION=sqlite
```

### Langkah 3: Permission Folder & Migrasi
```bash
# Berikan hak akses write ke web server (biasanya www-data)
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Jika menggunakan SQLite, pastikan file database juga memiliki permission write:
# touch database/database.sqlite
# sudo chown -R www-data:www-data database

# Jalankan migrasi dan seeder
php artisan migrate --force --seed
```

### Langkah 4: Konfigurasi Virtual Host Nginx
Buat file konfigurasi baru di VPS, contoh `/etc/nginx/sites-available/api-mahasiswa`:
```nginx
server {
    listen 80;
    server_name api-kelas.domain-anda.com; # Ganti dengan domain / IP VPS Anda
    root /var/www/api-mahasiswa/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock; # Sesuaikan versi PHP VPS Anda
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan konfigurasi dan reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/api-mahasiswa /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

*(Opsional)* Aktifkan SSL HTTPS gratis menggunakan Certbot:
```bash
sudo certbot --nginx -d api-kelas.domain-anda.com
```

---

## 🧪 Menjalankan Test Otomatis

Untuk memastikan semua endpoint siap digunakan, jalankan:
```bash
php artisan test
```
Semua 13 pengujian validasi, filter, CRUD, dan reset akan diverifikasi otomatis.

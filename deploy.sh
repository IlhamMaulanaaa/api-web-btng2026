#!/bin/bash
set -e

echo "🚀 Memulai Deployment Mahasiswa API (api-web.dnccudinus.org)..."

# Aktifkan maintenance mode jika server sedang melayani request
php artisan down || true

# Tarik perubahan terbaru dari Git repository jika menggunakan git
if [ -d ".git" ]; then
    echo "📦 Menarik perubahan terbaru dari repository Git..."
    git pull origin main
fi

# Update dan optimasi autoloader Composer
echo "📦 Menginstal dependensi Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Jalankan migrasi basis data
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# Bersihkan dan re-cache konfigurasi
echo "⚡ Mengoptimalkan cache Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Pastikan hak akses folder storage, cache, dan SQLite database aman
echo "🔒 Mengatur hak akses Linux (www-data)..."
if [ "$EUID" -eq 0 ]; then
    chown -R www-data:www-data storage bootstrap/cache database
    chmod -R 775 storage bootstrap/cache database
    if [ -f "database/database.sqlite" ]; then
        chmod 664 database/database.sqlite
    fi
fi

# Nonaktifkan maintenance mode
php artisan up

echo "✅ Deployment selesai! API Mahasiswa live di https://api-web.dnccudinus.org"

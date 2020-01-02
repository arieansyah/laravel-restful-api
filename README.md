# How To Install
1. Pastikan anda sudah menginstalasi web server (Apache / Nginx), PHP, dan MySQL
2. Clone repository ini
3. Buat database
4. Buat file .env via terminal `cp env.example .env`
5. Update konfigurasi database pada file `.env`
6. Jalankan Perintah via terminal or CMD `composer install`
6. Migrate database via terminal `php artisan migrate`
7. Jalankan `php artisan serve`

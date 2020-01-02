# How To Install
1. Make sure you have installed a web server (Apache / Nginx), PHP, and MySQL
2. Clone this Repository
3. Create database
4. Make file .env via terminal or CMD `cp env.example .env`
5. Update Configuration database in file `.env`
6. Run Commend via terminal or CMD `composer install`
7. Run  `php artisan key:generate`
8. Run `php artisan jwt:secret`
9. Run `php artisan migrate`
10. Run `php artisan serve`

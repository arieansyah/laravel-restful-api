# How To Install
- Make sure you have installed a web server (Apache / Nginx), PHP, MySQL and Redis
- Clone this Repository
- Create database
- Run Commend via terminal or CMD `composer install`
- Make file .env via terminal or CMD `cp env.example .env`
- Update Configuration database in file `.env`
- Set `CACHE_DRIVER=redis`
- Set `QUEUE_CONNECTION=redis`
- Run `php artisan key:generate`
- Run `php artisan jwt:secret`
- Run `php artisan config:cache`
- Run `php artisan migrate`
- Run `php artisan serve`

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Description

ITMove is a website that allows users to browse and book trips, as well as request their own custom tour trips.

## Prerequisites

- PHP >= 7.2.5
- Composer
- Xampp (A web server)
- Ngrok (Proxy server)

## Features

- Laravel 8.0 - The PHP web framework used.
- Bootstrap 5.3 - Front-end framework
- LiveWire - Dynamic Front-end
- MidTrans - Payment integration

## Installing

1. Clone the repository to your local machine: git clone https://github.com/roywenangr/ITMove-v99.git

2. Install dependencies: composer install

3. Create a new database and configure your .env file (database name: ITMove, MidTrans, Mailstrap, Google)

4. Run the migrations and seedings php artisan migrate --seed

5. Connect the storage: php artisan storage:link

6. Start the development server: php artisan serve

7. Run ngrok and make the server live: ngrok ngrok http {PORT}

8. Copy the forwarding link and login to Midtrans sanbox https://dashboard.sandbox.midtrans.com/login

9. Go to Setting > Configuration and paste the forwarding link. Add "/api/callback" at the end. Lastly, scroll and click Update button.

## Authors
Roy Wenang Robbani
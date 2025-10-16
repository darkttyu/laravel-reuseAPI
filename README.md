<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Laravel reUSEAPI

Laravel reuseAPI is an open-source project that aims to help Laravel programmers by providing a boilerplate template for their APIs, making API Development easier and more efficient. 

## Requirements

- PHP 8.2.12 or higher
- Laravel 12.x
- Composer 2.8.x

## Features 
- Authentication via [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- Permissions and Roles via [Laravel Spatie](https://spatie.be/docs/laravel-permission/v6/introduction)

## Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/laravel-reuseAPI.git

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Install and configure Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Publish Spatie Permission migrations
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

## Quick Start Guide

1. Configure your database in `.env`
2. Set up authentication
3. Define roles and permissions
4. Start building your API endpoints

## Available API Endpoints

Document your main API endpoints here, for example:

```text
POST   /api/auth/login
POST   /api/auth/register
GET    /api/user/profile
...
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security Vulnerabilities

If you discover a security vulnerability within reuseAPI, please send an e-mail to Carl Fernandez via [ctrlfrz0710@gmail.com](mailto:ctrlfrz0710@gmail.com). All security vulnerabilities will be promptly addressed.

## License

reuseAPI is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
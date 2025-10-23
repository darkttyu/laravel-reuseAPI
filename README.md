## About Laravel reuseAPI

A Laravel 12 API boilerplate with token auth via Sanctum and authorization via Spatie Permissions.

## Features
- ✅ Complete authentication system (register, login, email verification, password reset)
- ✅ Token-based auth with Laravel Sanctum
- ✅ Role-based permissions with Spatie Laravel Permission
- ✅ API rate limiting
- ✅ Swagger/OpenAPI documentation
- ✅ Feature tests
- ✅ Health check endpoint

## Requirements
- PHP 8.2+
- Laravel 12.x
- Composer 2.8+
- Database (PostgreSQL recommended)

## Installation
```bash
git clone https://github.com/yourusername/laravel-reuseAPI.git
cd laravel-reuseAPI
composer install
cp .env.example .env
php artisan key:generate
```

Configure `.env`:
- DB_*
- MAIL_* (if you’ll send real emails)
- SALT=<your-random-string>  # used for password hashing in this project

Run migrations:
```bash
php artisan migrate
```

Seed roles and permissions (can be customized in CreateRoles/Permissions.php):
```bash
php artisan roles:create
php artisan permissions:create
```

Generate Swagger documentation:
```bash
php artisan l5-swagger:generate
```

## API Documentation

Interactive API documentation is available via Swagger UI:

**URL:** `http://localhost:8000/api/documentation`

The documentation includes all endpoints with request/response examples and the ability to test endpoints directly from the browser.

## API Endpoints

All endpoints are documented in the interactive Swagger UI at `/api/documentation`.

**Quick Overview:**
- `POST /api/v1/auth/register` - Create new user account
- `POST /api/v1/auth/verify-email` - Verify email with token
- `POST /api/v1/auth/login` - Login and receive authentication token
- `POST /api/v1/auth/logout` - Revoke current token (requires auth)
- `POST /api/v1/auth/forgot-password` - Request password reset
- `POST /api/v1/auth/reset-password` - Reset password with token
- `GET /up` - Health check endpoint

**Note:** All request/response examples, validation rules, and interactive testing are available in the Swagger documentation via `http://localhost:8000/api/documentation` after you do ```bash php artisan serve```

## Roles and Permissions (Spatie)
Create roles and permissions:
```bash
php artisan roles:create
php artisan permissions:create
```

Protect routes
```php
// routes/api.php
Route::middleware(['auth:sanctum', 'role:admin', 'permission:view_users'])->group(function () {
    // your protected routes...
});
```

## Rate Limiting

The API includes rate limiting to prevent abuse:
- **Auth endpoints:** 20 requests per minute per IP
- **General API endpoints:** 60 requests per minute per user/IP

When rate limit is exceeded, you'll receive a `429 Too Many Requests` response with retry information.

## Testing

Run the test suite:
```bash
php artisan test
```

## Health Check

Monitor your API status:
```bash
GET /up
```
Returns `200 OK` when the application is running.

## Notes
- Password hashing in this project concatenates `SALT` from `.env` before hashing.
- Email verification currently returns a numeric token in the API response (you should wire a mailer in production).
- Reset password tokens are logged to `storage/logs/laravel.log` for testing (implement email in production).
- Comments are provided in specific files so that you won't get lost when making customizations.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security Vulnerabilities

If you discover a security vulnerability within reuseAPI, please send an e-mail to Carl Fernandez via [ctrlfrz0710@gmail.com](mailto:ctrlfrz0710@gmail.com). All security vulnerabilities will be promptly addressed.

## License

reuseAPI is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
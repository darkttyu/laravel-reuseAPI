## About Laravel reuseAPI

A Laravel 12 API boilerplate with token auth via Sanctum and authorization via Spatie Permissions.

## Requirements
- PHP 8.2+
- Laravel 12.x
- Composer 2.8+
- Database (PostgreSQL via DBeaver)

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

## API Endpoints
All endpoints are under `/api/auth` per `routes/api.php`.

- POST `/api/auth/register`
- POST `/api/auth/login`
- POST `/api/auth/verify-email`
- POST `/api/auth/forgot-password`
- POST `/api/auth/reset-password`
- POST `/api/auth/logout` (requires `auth:sanctum`)

### Auth: Requests and examples

Register
- Body: `{ "name": "John Doe", "email": "john@example.com", "password": "secret123" }`
- Response: includes `email_token` (for demo, normally emailed)
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"secret123"}'
```

Verify Email
- Body: `{ "token": 123456 }`
```bash
curl -X POST http://localhost:8000/api/auth/verify-email \
  -H "Content-Type: application/json" \
  -d '{"token":123456}'
```

Login
- Body: `{ "email": "john@example.com", "password": "secret123" }`
- Response: `{ "token": "<sanctum_token>" }`
- Note: login requires the email to be verified first.
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"secret123"}'
```

Authenticated requests
- Include: `Authorization: Bearer <token>`

Logout
```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer <token>"
```

Forgot Password
- Body: `{ "email": "john@example.com" }`

Reset Password
- Body: `{ "old_password": "secret123", "new_password": "newSecret123", "token": "<reset_token>" }`

Validation rules
- Register: name (required), email (email, unique), password (min:8)
- Login: email (email), password (min:8)
- Verify Email: token (integer)
- Forgot Password: email (email)
- Reset Password: old_password (min:8), new_password (min:8), token (string)

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

Notes
- Password hashing in this project concatenates `SALT` from `.env` before hashing.
- Email verification currently returns a numeric token in the API response (you should wire a mailer in production).
- Comments are provided in specific files so that you won't get lost when making customizations.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security Vulnerabilities

If you discover a security vulnerability within reuseAPI, please send an e-mail to Carl Fernandez via [ctrlfrz0710@gmail.com](mailto:ctrlfrz0710@gmail.com). All security vulnerabilities will be promptly addressed.

## License

reuseAPI is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
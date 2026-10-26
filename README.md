# Sembark URL Shortener

A multi-company URL shortener built with Laravel and MySQL.

## Requirements

- PHP 8.5.12
- Composer
- MySQL
- Node.js and npm (if frontend assets need to be built)

## Setup Instructions

### 1. Clone the repository using it's url
### 2. Install dependencies

composer install
npm install

### 3. Configure environment

Create your local environment file:

Copy-Item .env.example .env

Generate the application key:

php artisan key:generate

### 4. Configure the database

Create a MySQL database named `sembark_url_shortener`.

Update the database credentials in `.env`:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sembark_url_shortener
DB_USERNAME=root
DB_PASSWORD=

Use the credentials configured for your local MySQL installation.

### 5. Run migrations and seed SuperAdmins

php artisan migrate
php artisan db:seed --class=SuperAdminSeeder

### 6. Start the application

php artisan serve

Open `http://127.0.0.1:8000` in your browser.

### 7. Run tests

php artisan test

## Development SuperAdmin Accounts

For local testing only:

| Email | Password |
|---|---|
| `superadmin1@example.com` | `ChangeMe@123` |
| `superadmin2@example.com` | `ChangeMe@456` |

Do not use these demo credentials in production.

## Notes

- Invitations expire after seven days.
- SuperAdmin can invite Admins and view URLs across companies.
- Admin can invite Admins or Members within their company.
- Members can create short URLs and view only their own URLs.
- SuperAdmin cannot create short URLs.
- Public short links redirect to their original URLs.
- This project uses Laravel 13.38.0. The assignment specifies Laravel 10, 11, or 12 as permitted versions.

# Laravel Photo API Application

This is a Laravel application with OAuth authentication and API capabilities.

## Requirements

- PHP >= 8.0
- Laravel >= 9.0
- Composer
- MySQL or other relational database

## Installation

1. Clone this repository to your local machine:
git clone https://github.com/rohmanie55/laravel-photos-api.git

2. Change directory into the cloned repository:
cd laravel-photos-api

3. Install dependencies:
composer install

4. Copy the `.env.example` file to `.env` and modify the database and other configuration settings as necessary.

5. Generate an application key:
php artisan key:generate

6. Create a database and update the `.env` file with the database name, username, and password.

7. Run database migrations:
php artisan migrate

8. Create Oauth Client key:
php artisan passport:client --personal

9. update the `.env` file with new client key
PASSPORT_PERSONAL_ACCESS_CLIENT_ID="client-id-value"
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="unhashed-client-secret-value"

10. Link storage folder:
php artisan storage:link

10. Seed the database (optional):
php artisan db:seed

11. Run testing (optional):
php artisan test

## Running the Application

1. Start a development server:
php artisan serve

2. Visit the URL in your browser: `http://localhost:8000`

## API Endpoints
https://github.com/rohmanie55/laravel-photos-api/blob/master/photos.postman_collection.json



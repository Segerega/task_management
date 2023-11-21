# Laravel Project Management Tool

## Introduction

This Laravel Project Management Tool is a robust system designed for collaborative project management. It facilitates
task creation, assignment, progress monitoring, and status tracking, ensuring an efficient workflow for teams of all
sizes.

## Requirements

To run this application, you need:

- PHP >= 8.2
- MySQL
- Composer

  **OR**

- Docker
- Docker Compose

## Installation

To set up the project on your local machine, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Segerega/task_management.git

2. **Install Dependencies**

    ```
    composer install
    ```

3. **Environment File**

   Copy the `.env.example` file to a new file named `.env`.

    ```
    cp .env.example .env
    ```

   Then, open `.env` and set your database credentials and other environment variables as required.

4. **Generate Application Key**

    ```
    php artisan key:generate
    ```

5. **Run Migrations** (If you have any database migrations)

    ```
    php artisan migrate
    ```

6. **Install Laravel Passport**

    ```
    php artisan passport:install
    ```

7. **Run the Server**

    ```
    php artisan serve
    ```

This will start the server at `http://localhost:8000`.

8. **Or use Docker yaml configuration**
    ```
    docker-compose up -d
    docker-compose exec app php artisan key:generate
    docker-compose exec app composer install
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan passport:install
    ./vendor/bin/sail up
   ```

## Testing

The application includes both feature tests and unit tests.

1. **Run Tests**

   Run the PHPUnit test suite:

    ```
    php artisan test
    ```

   This command runs all the tests and outputs the results.

2. **Specific Tests**

   To run specific tests, use the PHPUnit command:

    ```
    ./vendor/bin/phpunit --filter NameOfTheTest
    ```

## Notes

- If you encounter any issues during setup, ensure your server and PHP environments meet Laravel's requirements.
- For detailed documentation on Laravel, visit [Laravel Documentation](https://laravel.com/docs).

# Project Setup Guide

## 📋 Prerequisites

- PHP ≥ 8.2
- Composer
- MySQL ≥ 8.0
- Git (optional)

## Cloning the Repository

1. Open a terminal or command prompt.
2. Navigate to the directory where you want to clone the project.
   ```sh
   cd /path/to/your/directory
   ```
3. Clone the repository using Git:
   ```sh
   git clone https://github.com/KodeX-Development-Lab/assignment-expense-tracker.git
   ```
4. change directory into the project directory:
   ```sh
   cd project_name
   ```


## Environment Configuration

Copy the `.env.example` file to create a new `.env` file:
   ```sh
   cp .env.example .env
   composer install
   ```

   And replace the database credentials here.
   ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=kodex_budget_tracker
    DB_USERNAME=root
    DB_PASSWORD=
   ```


## Database Migrating and Running the Application

   ```sh
    php artisan migrate:fresh
    php artisan db:seed --class=UserSeeder
    php artisan module:seed BudgetTracker

    php artisan serve --port=8000
   ```

The project should now be up and running! <br/>
Access it via `http://localhost:8000` in your browser.

## Documentation




Happy Coding!

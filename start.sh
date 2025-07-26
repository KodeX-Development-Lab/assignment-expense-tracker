php artisan migrate:fresh
# php artisan world:install
php artisan db:seed --class=UserSeeder
php artisan module:seed BudgetTracker
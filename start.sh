php artisan migrate
php artisan world:install
php artisan db:seed --class=UserSeeder
php artisan module:migrate BudgetTracker
php artisan module:seed --class=BudgetTrackerIconSeeder BudgetTracker
php artisan module:seed --class=BudgetTrackerCategorySeeder BudgetTracker
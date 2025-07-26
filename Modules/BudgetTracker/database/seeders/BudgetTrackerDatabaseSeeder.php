<?php
namespace Modules\BudgetTracker\Database\Seeders;

use Illuminate\Database\Seeder;

class BudgetTrackerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BudgetTrackerCategorySeeder::class,
            BudgetItemSeeder::class,
        ]);
    }
}

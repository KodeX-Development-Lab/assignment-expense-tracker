<?php
namespace Modules\BudgetTracker\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BudgetTrackerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // incomeS
            ['name' => 'Salary', 'type' => 'income', 'icon' => 'briefcase'],
            ['name' => 'Sale', 'type' => 'income', 'icon' => 'dollar-sign'],
            ['name' => 'Rental', 'type' => 'income', 'icon' => 'home'],
            ['name' => 'Grants', 'type' => 'income', 'icon' => 'gift'],
            ['name' => 'Refunds', 'type' => 'income', 'icon' => 'arrow-down'],
            ['name' => 'Coupons', 'type' => 'income', 'icon' => 'tag'],
            ['name' => 'Awards', 'type' => 'income', 'icon' => 'trophy'],
            ['name' => 'Bonus', 'type' => 'income', 'icon' => 'percent'],

            // expenseS
            ['name' => 'Food', 'type' => 'expense', 'icon' => 'utensils'],
            ['name' => 'Drink', 'type' => 'expense', 'icon' => 'cup-soda'],
            ['name' => 'Clothing', 'type' => 'expense', 'icon' => 'shirt'],
            ['name' => 'Debt', 'type' => 'expense', 'icon' => 'credit-card'],
            ['name' => 'Shopping', 'type' => 'expense', 'icon' => 'shopping-cart'],
            ['name' => 'Transportation', 'type' => 'expense', 'icon' => 'car'],
            ['name' => 'Home', 'type' => 'expense', 'icon' => 'home'],
            ['name' => 'Travel', 'type' => 'expense', 'icon' => 'airplane'],
            ['name' => 'Bills', 'type' => 'expense', 'icon' => 'receipt'],
            ['name' => 'Snacks', 'type' => 'expense', 'icon' => 'sandwich'],
            ['name' => 'Tax', 'type' => 'expense', 'icon' => 'banknote'],
            ['name' => 'Electronic', 'type' => 'expense', 'icon' => 'tv'],
            ['name' => 'Health', 'type' => 'expense', 'icon' => 'heart-pulse'],
            ['name' => 'Entertainment', 'type' => 'expense', 'icon' => 'gamepad-2'],
            ['name' => 'Insurance', 'type' => 'expense', 'icon' => 'shield'],
            ['name' => 'Beauty', 'type' => 'expense', 'icon' => 'scissors'],
        ];

        foreach ($categories as $item) {
            DB::table('budget_tracker_categories')->insert([
                'user_id'              => 0,
                'name'                 => $item['name'],
                'type'                 => $item['type'],
                'color'                => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), // random hex color
                'is_default_by_system' => true,
                'status'               => true,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

        }
    }
}

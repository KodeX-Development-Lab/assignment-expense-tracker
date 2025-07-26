<?php
namespace Modules\BudgetTracker\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\BudgetTracker\Enums\BudgetTypes;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;
use Modules\BudgetTracker\Models\DailyBudget;
use Modules\BudgetTracker\Models\DailyBudgetItem;

class BudgetItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::first();

        // $dailyBudget = DailyBudget::firstOrCreate(
        //     ['user_id' => $user->id, 'date' => Carbon::now()->format('Y-m-d')]
        // );

        // $income_categories  = BudgetTrackerCategory::where('type', BudgetTypes::INCOME->value)->pluck('id')->toArray();
        // $expense_categories = BudgetTrackerCategory::where('type', BudgetTypes::EXPENSE->value)->pluck('id')->toArray();

        // foreach ($income_categories as $key => $income_category) {
        //     DailyBudgetItem::create([
        //         'budget_id'    => $dailyBudget->id,
        //         'type'         => BudgetTypes::INCOME->value,
        //         'category_id'  => $income_category,
        //         'amount'       => rand(100, 1000),
        //         'remark'       => "Test",
        //         'processed_at' => Carbon::now(),
        //     ]);
        // }

        // foreach ($expense_categories as $key => $expense_category) {
        //     DailyBudgetItem::create([
        //         'budget_id'    => $dailyBudget->id,
        //         'type'         => BudgetTypes::EXPENSE->value,
        //         'category_id'  => $expense_category,
        //         'amount'       => rand(100, 1000),
        //         'remark'       => "Test",
        //         'processed_at' => Carbon::now(),
        //     ]);
        // }

        $user = User::first();

// Define the date range
        $startDate = Carbon::create(2025, 1, 1);
        $endDate   = Carbon::create(2025, 7, 31);

        $incomeCategories  = BudgetTrackerCategory::where('type', BudgetTypes::INCOME->value)->pluck('id')->toArray();
        $expenseCategories = BudgetTrackerCategory::where('type', BudgetTypes::EXPENSE->value)->pluck('id')->toArray();

        for ($month = $startDate->copy(); $month->lte($endDate); $month->addMonth()) {
            // Create a daily budget for each month (using first day of month as representative)
            $dailyBudget = DailyBudget::firstOrCreate([
                'user_id' => $user->id,
                'date'    => $month->format('Y-m-d'),
            ]);

            // Generate income (higher amounts)
            $totalIncome = 0;
            foreach ($incomeCategories as $incomeCategory) {
                $amount = rand(100000, 300000); // Higher range for income
                DailyBudgetItem::create([
                    'budget_id'    => $dailyBudget->id,
                    'type'         => BudgetTypes::INCOME->value,
                    'category_id'  => $incomeCategory,
                    'amount'       => $amount,
                    'remark'       => "Income for " . $month->format('F Y'),
                    'processed_at' => $month,
                ]);
                $totalIncome += $amount;
            }

            // Generate expenses (ensure total is less than income)
            $totalExpenses = 0;
            foreach ($expenseCategories as $key => $expenseCategory) {
                // Calculate remaining available for expenses
                $remaining = $totalIncome - $totalExpenses;

                // If this is the last expense category, use up to 80% of remaining
                if ($expenseCategory === end($expenseCategories)) {
                    $amount = rand(100000, min(200000, $remaining * 0.8));
                } else {
                    $amount = rand(100000, min(200000, $remaining / (count($expenseCategories) - $key)));
                }

                DailyBudgetItem::create([
                    'budget_id'    => $dailyBudget->id,
                    'type'         => BudgetTypes::EXPENSE->value,
                    'category_id'  => $expenseCategory,
                    'amount'       => $amount,
                    'remark'       => "Expense for " . $month->format('F Y'),
                    'processed_at' => $month,
                ]);
                $totalExpenses += $amount;
            }

            // For more realistic data, you could create multiple entries per month
            $daysInMonth     = $month->daysInMonth;
            $entriesPerMonth = rand(5, 10); // 5-10 entries per month

            for ($i = 0; $i < $entriesPerMonth; $i++) {
                $randomDay  = rand(1, $daysInMonth);
                $randomDate = $month->copy()->day($randomDay);

                // Alternate between income and expense
                $type       = $i % 2 === 0 ? BudgetTypes::INCOME : BudgetTypes::EXPENSE;
                $categories = $type === BudgetTypes::INCOME ? $incomeCategories : $expenseCategories;

                DailyBudgetItem::create([
                    'budget_id'    => $dailyBudget->id,
                    'type'         => $type->value,
                    'category_id'  => $categories[array_rand($categories)],
                    'amount'       => $type === BudgetTypes::INCOME ? rand(100000, 200000) : rand(100, 1000),
                    'remark'       => ($type === BudgetTypes::INCOME ? "Income" : "Expense") . " on " . $randomDate->format('M j, Y'),
                    'processed_at' => $randomDate,
                ]);
            }
        }
    }
}

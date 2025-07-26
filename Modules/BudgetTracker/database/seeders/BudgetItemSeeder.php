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
        $user = User::first();

        $dailyBudget = DailyBudget::firstOrCreate(
            ['user_id' => $user->id, 'date' => Carbon::now()->format('Y-m-d')]
        );

        $income_categories  = BudgetTrackerCategory::where('type', BudgetTypes::INCOME->value)->pluck('id')->toArray();
        $expense_categories = BudgetTrackerCategory::where('type', BudgetTypes::EXPENSE->value)->pluck('id')->toArray();

        foreach ($income_categories as $key => $income_category) {
            DailyBudgetItem::create([
                'budget_id'    => $dailyBudget->id,
                'type'         => BudgetTypes::INCOME->value,
                'category_id'  => $income_category,
                'amount'       => rand(100, 1000),
                'remark'       => "Test",
                'processed_at' => Carbon::now(),
            ]);
        }

        foreach ($expense_categories as $key => $expense_category) {
            DailyBudgetItem::create([
                'budget_id'    => $dailyBudget->id,
                'type'         => BudgetTypes::EXPENSE->value,
                'category_id'  => $expense_category,
                'amount'       => rand(100, 1000),
                'remark'       => "Test",
                'processed_at' => Carbon::now(),
            ]);
        }

    }
}

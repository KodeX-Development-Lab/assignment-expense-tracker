<?php
namespace Modules\BudgetTracker\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\DailyBudget;
use Modules\BudgetTracker\Models\DailyBudgetItem;

class BudgetTrackerReportRepository
{

    public function getAllBudgetsBrief()
    {
        $query = DailyBudgetItem::join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id());

        $results = $query->selectRaw('
        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
    ')->first();

        $totalIncome  = (float) ($results->total_income ?? 0);
        $totalExpense = (float) ($results->total_expense ?? 0);

        $balance         = $totalIncome - $totalExpense;
        $usagePercentage = $totalIncome > 0 ? ($totalExpense / $totalIncome) * 100 : 0;

        return [
            'total_income'     => $totalIncome,
            'total_expense'    => $totalExpense,
            'balance'          => $balance,
            'usage_percentage' => $usagePercentage,
        ];
    }

    public function getTotalBriefBudget(Request $request)
    {
        $query = DailyBudgetItem::join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id());

        $filterType = $request->filter_type ?? 'monthly';
        $now        = Carbon::now();

        switch ($filterType) {
            case 'monthly':
                $input = $request->month ? Carbon::parse($request->month) : Carbon::now();
                $month = $input->format('m');
                $year  = $input->format('Y');
                $query->whereYear('processed_at', $year)
                    ->whereMonth('processed_at', $month);
                break;

            case 'yearly':
                $year = $request->year ?? Carbon::now()->format('Y');
                $query->whereYear('processed_at', $year);
                break;

            case 'custom':

                if ($request->start_date) {
                    $start_date = $request->start_date ?? Carbon::now()->format('Y-m-d');
                    $query->whereDate('daily_budget_items.processed_at', '>=', $start_date);
                }

                if ($request->end_date) {
                    $end_date = $request->end_date ?? Carbon::now()->format('Y-m-d');
                    $query->whereDate('daily_budget_items.processed_at', '<=', $end_date);
                }

                break;
        }

        $results = $query->selectRaw('
        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
    ')->first();

        $totalIncome  = (float) ($results->total_income ?? 0);
        $totalExpense = (float) ($results->total_expense ?? 0);

        $balance         = $totalIncome - $totalExpense;
        $usagePercentage = $totalIncome > 0 ? ($totalExpense / $totalIncome) * 100 : 0;

        return [
            'total_income'     => $totalIncome,
            'total_expense'    => $totalExpense,
            'balance'          => $balance,
            'usage_percentage' => $usagePercentage,
        ];
    }

    public function getRecentForCurrentMonth()
    {
        $now = Carbon::now();

        $query = DailyBudgetItem::join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id())
            ->whereMonth('daily_budget_items.processed_at', $now->format('m'))
            ->whereYear('daily_budget_items.processed_at', $now->format('Y'));

        $results = $query->selectRaw('
        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
    ')->first();

        $totalIncome  = (float) ($results->total_income ?? 0);
        $totalExpense = (float) ($results->total_expense ?? 0);

        $items = DailyBudgetItem::with(['category'])
            ->join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id())
            ->whereMonth('daily_budget_items.processed_at', $now->format('m'))
            ->whereYear('daily_budget_items.processed_at', $now->format('Y'))
            ->orderByDesc('daily_budget_items.processed_at')
            ->take(10)
            ->get();

        return [
            'total_income'  => $totalIncome,
            'total_expense' => $totalExpense,
            'items'         => $items,
        ];
    }

    public function getBriefBudget(Request $request)
    {
        $filterType = $request->filter_type ?? 'monthly';
        $now        = Carbon::now();

        $query = DailyBudgetItem::join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id());

        switch ($filterType) {
            case 'monthly':
                $input = $request->month ? Carbon::parse($request->month) : Carbon::now();
                $month = $input->format('m');
                $year  = $input->format('Y');
                $query->whereYear('processed_at', $year)
                    ->whereMonth('processed_at', $month);
                break;

            case 'yearly':
                $year = $request->year ?? Carbon::now()->format('Y');
                $query->whereYear('processed_at', $year);
                break;

            case 'custom':
                $query->whereDate('daily_budget_items.processed_at', '>=', $request->start_date);
                $query->whereDate('daily_budget_items.processed_at', '<=', $request->end_date);
                break;
        }

        $results = $query->selectRaw('
        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
    ')->first();

        $totalIncome  = (float) ($results->total_income ?? 0);
        $totalExpense = (float) ($results->total_expense ?? 0);

        $balance         = $totalIncome - $totalExpense;
        $usagePercentage = $totalIncome > 0 ? ($totalExpense / $totalIncome) * 100 : 0;

        return [
            'total_income'     => $totalIncome,
            'total_expense'    => $totalExpense,
            'balance'          => $balance,
            'usage_percentage' => $usagePercentage,
        ];
    }

    public function getMonthlyBudgets(Request $request)
    {
        $perPage = $request->display ?? 10;
        $now     = Carbon::now();
        $month   = $request->month ?? $now->format('m');
        $year    = $request->year ?? $now->format('Y');

        $data = DailyBudget::with(['items.category'])
            ->where('daily_budgets.user_id', auth()->id())
            ->orderByDesc('daily_budgets.date')
            ->where(function ($query) use ($month, $year) {
                $query->whereMonth('daily_budgets.date', $month)
                    ->whereYear('daily_budgets.date', $year);
            })
            ->get();

        return $data;
    }

    public function getBudgetSummary(Request $request)
    {
        $filterType = $request->filter_type ?? 'monthly';
        $now        = Carbon::now();

        $query = DailyBudgetItem::join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id());

        switch ($filterType) {
            case 'monthly':
                $input = $request->month ? Carbon::parse($request->month) : Carbon::now();
                $month = $input->format('m');
                $year  = $input->format('Y');
                $query->whereYear('processed_at', $year)
                    ->whereMonth('processed_at', $month)
                    ->selectRaw('
                        DATE(daily_budgets.date) as label,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) -
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as balance
                    ')
                    ->groupBy('label')
                    ->orderBy('label');
                break;

            case 'yearly':
                $year = $request->year ?? Carbon::now()->format('Y');
                $query->whereYear('processed_at', $year)
                    ->selectRaw('
                        MONTH(daily_budgets.date) as month,
                        MONTHNAME(date) as label,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) -
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as balance
                    ')
                    ->groupBy('month', 'label')
                    ->orderBy('month');
                break;

            case 'custom':
                $start_date = $request->start_date ?? Carbon::now()->format('Y-m-d');
                $end_date   = $request->end_date ?? Carbon::now()->format('Y-m-d');

                $query->whereDate('daily_budget_items.processed_at', '>=', $start_date);
                $query->whereDate('daily_budget_items.processed_at', '<=', $end_date)
                    ->selectRaw('
                        DATE(daily_budgets.date) as label,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense,
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) -
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as balance
                    ')
                    ->groupBy('label')
                    ->orderBy('label');
                break;
        }

        return $query->get();
    }

    public function getBudgetReportOnCategories(Request $request, $budgetType)
    {
        $filterType = $request->filter_type ?? 'monthly';
        $now        = Carbon::now();

        $query = DailyBudgetItem::with(['category'])->join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id())
            ->where('daily_budget_items.type', $budgetType)
            ->groupBy('daily_budget_items.category_id');

        switch ($filterType) {
            case 'monthly':
                $input = $request->month ? Carbon::parse($request->month) : Carbon::now();
                $month = $input->format('m');
                $year  = $input->format('Y');
                $query->whereYear('processed_at', $year)
                    ->whereMonth('processed_at', $month);
                break;

            case 'yearly':
                $year = $request->year ?? Carbon::now()->format('Y');
                $query->whereYear('processed_at', $year);
                break;

            case 'custom':
                if ($request->start_date && $request->end_date) {
                    $query->whereDate('daily_budget_items.processed_at', '>=', $request->start_date);
                    $query->whereDate('daily_budget_items.processed_at', '<=', $request->end_date);
                }
                break;
        }

        $items = $query->selectRaw(
            'category_id, SUM(daily_budget_items.amount) AS amount'
        )
            ->get();

        $total_amount = $items->sum('amount');

        $items = collect($items)->map(function ($item) use ($total_amount) {
            return [
                'id'         => $item->category_id,
                'category'   => $item->category,
                'amount'     => $item->amount,
                'percentage' => round(($item->amount / $total_amount) * 100),
            ];
        });

        return [
            'total_amount' => $total_amount,
            'items'        => $items,
        ];
    }
}

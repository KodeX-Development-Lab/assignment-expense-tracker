<?php
namespace Modules\BudgetTracker\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Services\BudgetTrackerReportService;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerReportServiceImpl;
use Modules\BudgetTracker\Transformers\SummaryBudgetResource;

class BudgetTrackerReportController extends Controller
{
    private BudgetTrackerReportService $budgetTrackerReportService;

    public function __construct(BudgetTrackerReportServiceImpl $budgetTrackerReportService)
    {
        $this->budgetTrackerReportService = $budgetTrackerReportService;
    }

    public function getOverviewReport(Request $request)
    {
        $request->merge([
            'filter_type' => 'yearly',
        ]);

        $summary_budgets = $this->budgetTrackerReportService->getBudgetSummary($request);

        return view("dashboard.index", [
            'brief'                        => $this->budgetTrackerReportService->getTotalBriefBudget(),
            'current_month_recent_budgets' => $this->budgetTrackerReportService->getRecentForCurrentMonth(),
            'summary_budgets'              => SummaryBudgetResource::collection($summary_budgets),
        ]);
    }

    public function getRecentBudgets(Request $request)
    {
        return view("recent.index", [
            'brief'         => $this->budgetTrackerReportService->getBriefBudget($request),
            'daily_budgets' => collect($this->budgetTrackerReportService->getMonthlyBudgets($request))->filter(function ($daily_budgets) {
                return $daily_budgets->items->count();
            }),
        ]);
    }

    public function getMonthlyReport(Request $request)
    {
        $request->merge([
            'filter_type' => 'monthly',
        ]);

        $summary_budgets = $this->budgetTrackerReportService->getBudgetSummary($request);

        $income_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'income');  
        $expense_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'expense');

        return view("reports.monthly", [
            'brief'                        => $this->budgetTrackerReportService->getTotalBriefBudget(),
            'summary_budgets'              => SummaryBudgetResource::collection($summary_budgets),
            'income_budget_on_categories'  => $income_budget_on_categories,
            'expense_budget_on_categories' => $expense_budget_on_categories,
        ]);
    }

    public function getYearlyReport(Request $request)
    {
        $request->merge([
            'filter_type' => 'yearly',
        ]);

        $summary_budgets = $this->budgetTrackerReportService->getBudgetSummary($request);

        $income_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'income');  
        $expense_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'expense');

        return view("reports.yearly", [
            'brief'                        => $this->budgetTrackerReportService->getTotalBriefBudget(),
            'summary_budgets'              => SummaryBudgetResource::collection($summary_budgets),
            'income_budget_on_categories'  => $income_budget_on_categories,
            'expense_budget_on_categories' => $expense_budget_on_categories,
        ]);

    }

    public function getCustomReport(Request $request)
    {
        $request->merge([
            'filter_type' => 'custom',
        ]);

        $summary_budgets = $this->budgetTrackerReportService->getBudgetSummary($request);

        $income_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'income');  
        $expense_budget_on_categories = $this->budgetTrackerReportService->getBudgetReportOnCategories($request, 'expense');

        return view("reports.custom", [
            'brief'                        => $this->budgetTrackerReportService->getTotalBriefBudget(),
            'summary_budgets'              => SummaryBudgetResource::collection($summary_budgets),
            'income_budget_on_categories'  => $income_budget_on_categories,
            'expense_budget_on_categories' => $expense_budget_on_categories,
        ]);
    }

    public function getBriefBudget(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'brief' => $this->budgetTrackerReportService->getBriefBudget($request),
            ],
            'message' => '',
        ], 200);
    }

    public function getMonthlyBudgets(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'daily_budgets' => $this->budgetTrackerReportService->getMonthlyBudgets($request),
            ],
            'message' => '',
        ], 200);
    }

    public function getBudgetSummary(Request $request)
    {
        $items = $this->budgetTrackerReportService->getBudgetSummary($request);
        return response()->json([
            'status'  => true,
            'data'    => [
                'summary_budgets' => SummaryBudgetResource::collection($items),
            ],
            'message' => '',
        ], 200);
    }

    public function getBudgetReportOnCategories(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'budgets_on_categories' => $this->budgetTrackerReportService->getBudgetReportOnCategories($request),
            ],
            'message' => '',
        ], 200);
    }
}

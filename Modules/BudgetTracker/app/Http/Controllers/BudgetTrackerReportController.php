<?php
namespace Modules\BudgetTracker\Http\Controllers;

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

        return response()->json([
            'status'  => true,
            'data'    => [
                'brief'                        => $this->budgetTrackerReportService->getTotalBriefBudget($request),
                'current_month_recent_budgets' => $this->budgetTrackerReportService->getRecentForCurrentMonth(),
                'summary_budgets'              => SummaryBudgetResource::collection($summary_budgets),
            ],
            'message' => '',
        ], 200);
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

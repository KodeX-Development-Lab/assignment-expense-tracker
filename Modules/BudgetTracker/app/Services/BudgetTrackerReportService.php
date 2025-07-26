<?php
namespace Modules\BudgetTracker\Services;

use Illuminate\Http\Request;

interface BudgetTrackerReportService
{
    public function getTotalBriefBudget();
    public function getRecentForCurrentMonth();
    public function getMonthlyBudgets(Request $request);
    public function getBriefBudget(Request $request);
    public function getBudgetSummary(Request $request);
    public function getBudgetReportOnCategories(Request $request, $type);
}

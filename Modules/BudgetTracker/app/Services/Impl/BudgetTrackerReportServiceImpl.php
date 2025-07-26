<?php
namespace Modules\BudgetTracker\Services\Impl;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Repositories\BudgetTrackerReportRepository;
use Modules\BudgetTracker\Services\BudgetTrackerReportService;

class BudgetTrackerReportServiceImpl implements BudgetTrackerReportService
{
    private BudgetTrackerReportRepository $budgetTrackerReportRepository;

    public function __construct(BudgetTrackerReportRepository $budgetTrackerReportRepository)
    {
        $this->budgetTrackerReportRepository = $budgetTrackerReportRepository;
    }

    public function getTotalBriefBudget()
    {
        return $this->budgetTrackerReportRepository->getTotalBriefBudget();
    }

    public function getRecentForCurrentMonth()
    {
        return $this->budgetTrackerReportRepository->getRecentForCurrentMonth();
    }

    public function getMonthlyBudgets(Request $request)
    {
        return $this->budgetTrackerReportRepository->getMonthlyBudgets($request);
    }

    public function getBriefBudget(Request $request)
    {
        return $this->budgetTrackerReportRepository->getBriefBudget($request);
    }

    public function getBudgetSummary(Request $request)
    {
        return $this->budgetTrackerReportRepository->getBudgetSummary($request);
    }

    public function getBudgetReportOnCategories(Request $request, $type)
    {
        return $this->budgetTrackerReportRepository->getBudgetReportOnCategories($request, $type);
    }
}

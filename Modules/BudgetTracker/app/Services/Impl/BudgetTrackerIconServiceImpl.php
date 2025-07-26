<?php
namespace Modules\BudgetTracker\Services\Impl;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Repositories\BudgetTrackerIconRepository;
use Modules\BudgetTracker\Services\BudgetTrackerIconService;

class BudgetTrackerIconServiceImpl implements BudgetTrackerIconService
{
    private BudgetTrackerIconRepository $budgetTrackerIconRepository;

    public function __construct(BudgetTrackerIconRepository $budgetTrackerIconRepository)
    {
        $this->budgetTrackerIconRepository = $budgetTrackerIconRepository;
    }

    public function findByParams(Request $request)
    {
        return $this->budgetTrackerIconRepository->findByParams($request);
    }

    public function findById($id)
    {
        return $this->budgetTrackerIconRepository->findById($id);
    }
}

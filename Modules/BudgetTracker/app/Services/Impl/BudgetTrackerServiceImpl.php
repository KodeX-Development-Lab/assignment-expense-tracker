<?php
namespace Modules\BudgetTracker\Services\Impl;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\DailyBudgetItem;
use Modules\BudgetTracker\Repositories\BudgetTrackerRepository;
use Modules\BudgetTracker\Services\BudgetTrackerService;

class BudgetTrackerServiceImpl implements BudgetTrackerService
{
    private BudgetTrackerRepository $budgetTrackerRepository;

    public function __construct(BudgetTrackerRepository $budgetTrackerRepository)
    {
        $this->budgetTrackerRepository = $budgetTrackerRepository;
    }

    public function findByParams(Request $request)
    {
        return $this->budgetTrackerRepository->findByParams($request);
    }

    public function findById($id)
    {
        return $this->budgetTrackerRepository->findById($id);
    }

    public function store(array $data)
    {
        return $this->budgetTrackerRepository->store($data);

    }

    public function update(DailyBudgetItem $item, array $data)
    {
        return $this->budgetTrackerRepository->update($item, $data);

    }

    public function delete(DailyBudgetItem $item)
    {
        return $this->budgetTrackerRepository->delete($item);
    }
}

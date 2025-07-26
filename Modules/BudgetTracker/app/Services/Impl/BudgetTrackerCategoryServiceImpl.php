<?php
namespace Modules\BudgetTracker\Services\Impl;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;
use Modules\BudgetTracker\Repositories\BudgetTrackerCategoryRepository;
use Modules\BudgetTracker\Services\BudgetTrackerCategoryService;

class BudgetTrackerCategoryServiceImpl implements BudgetTrackerCategoryService
{
    private BudgetTrackerCategoryRepository $budgetTrackerCategoryRepository;

    public function __construct(BudgetTrackerCategoryRepository $budgetTrackerCategoryRepository)
    {
        $this->budgetTrackerCategoryRepository = $budgetTrackerCategoryRepository;
    }

    public function findByParams(Request $request)
    {
        return $this->budgetTrackerCategoryRepository->findByParams($request);
    }

    public function findById($id)
    {
        return $this->budgetTrackerCategoryRepository->findById($id);
    }

    public function store(array $data)
    {
        return $this->budgetTrackerCategoryRepository->store($data);
    }

    public function update(BudgetTrackerCategory $category, array $data)
    {
        return $this->budgetTrackerCategoryRepository->update($category, $data);
    }

    public function delete(BudgetTrackerCategory $category)
    {
        return $this->budgetTrackerCategoryRepository->delete($category);
    }
}

<?php
namespace Modules\BudgetTracker\Services;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;

interface BudgetTrackerCategoryService
{
    public function findByParams(Request $request);

    public function findById($id);
    
    public function store(array $data);

    public function update(BudgetTrackerCategory $category, array $data);

    public function delete(BudgetTrackerCategory $category);
}

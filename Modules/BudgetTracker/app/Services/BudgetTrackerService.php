<?php
namespace Modules\BudgetTracker\Services;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\DailyBudgetItem;

interface BudgetTrackerService
{
    public function findByParams(Request $request);

    public function findById($id);
    public function store(array $data);
    public function update(DailyBudgetItem $item, array $data);

    public function delete(DailyBudgetItem $item);
}

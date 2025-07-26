<?php
namespace Modules\BudgetTracker\Services;

use Illuminate\Http\Request;

interface BudgetTrackerIconService
{
    public function findByParams(Request $request);

    public function findById($id);
}
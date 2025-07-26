<?php
namespace Modules\BudgetTracker\Repositories;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\BudgetTrackerIcon;

class BudgetTrackerIconRepository
{
    public function findByParams(Request $request)
    {
        $search  = $request->search ?? '';
        $perPage = $request->display ?? 10;

        return BudgetTrackerIcon::where('status', 1)
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                }
            })->paginate($perPage);
    }

    public function findById($id)
    {
        return BudgetTrackerIcon::findOrFail($id);
    }
}

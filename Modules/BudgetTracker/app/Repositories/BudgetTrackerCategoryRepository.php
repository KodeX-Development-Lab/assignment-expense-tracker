<?php
namespace Modules\BudgetTracker\Repositories;

use Illuminate\Http\Request;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;

class BudgetTrackerCategoryRepository
{
    public function findByParams(Request $request)
    {
        $search  = $request->search ?? '';
        $perPage = $request->display ?? 10;

        return BudgetTrackerCategory::where('status', 1)
            ->where(function ($query) use ($request, $search) {
                $query->where(function ($q) {
                    $q->where('is_default_by_system', 1)
                        ->orWhere('user_id', auth()->id());
                });

                if ($request->type != null && $request->type != 'All') {
                    $query->where('type', $request->type);
                }

                if ($search != '') {
                    $query->where('name', 'LIKE', "%$search%");
                }
            })
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function findById($id)
    {
        return BudgetTrackerCategory::findOrFail($id);
    }

    public function store(array $data)
    {
        return BudgetTrackerCategory::create([
            'user_id'              => auth()->id(),
            'name'                 => $data['name'],
            'type'                 => $data['type'],
            'color'                => $data['color'],
            'is_default_by_system' => $data['is_default_by_system'] ?? false,
            'status'               => true,
        ]);
    }

    public function update(BudgetTrackerCategory $category, array $data)
    {
        return $category->update([
            'name'                 => $data['name'] ?? $category->name,
            'type'                 => $data['type'] ?? $category->type,
            'color'                => $data['color'] ?? $category->color,
            'is_default_by_system' => $data['is_default_by_system'] ?? $category->is_default_by_system,
            'status'               => $data['status'] ?? $category->status,
        ]);
    }

    public function delete(BudgetTrackerCategory $category)
    {
        $category->delete();
    }
}

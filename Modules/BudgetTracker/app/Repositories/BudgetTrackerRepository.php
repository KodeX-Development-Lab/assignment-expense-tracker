<?php
namespace Modules\BudgetTracker\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\BudgetTracker\Models\DailyBudget;
use Modules\BudgetTracker\Models\DailyBudgetItem;

class BudgetTrackerRepository
{
    public function findByParams(Request $request)
    {
        $search  = $request->search ?? '';
        $perPage = $request->display ?? 10;

        $category_ids = collect(explode(",", $request->categories))->filter(function ($category_id) {
            return $category_id;
        })->values();

        $data = DailyBudgetItem::withTrashed(['category'])
            ->join('daily_budgets', 'daily_budgets.id', 'daily_budget_items.budget_id')
            ->where('daily_budgets.user_id', auth()->id())
            ->where(function ($query) use ($request, $category_ids, $search) {
                if ($request->type != null && strtolower($request->type) != 'all') {
                    $query->where('daily_budget_items.type', $request->type);
                }

                if (count($category_ids) > 0 && strtolower($request->categories) != 'all') {
                    $query->whereIn('daily_budget_items.category_id', $category_ids);
                }

                if ($request->start_date) {
                    $query->whereDate('daily_budget_items.processed_at', '>=', $request->start_date);
                }

                if ($request->end_date) {
                    $query->whereDate('daily_budget_items.processed_at', '<=', $request->end_date);
                }

                if ($search != '') {
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('category', function ($subquery) use ($search) {
                            $subquery->where('name', 'LIKE', "%$search%");
                        })
                            ->orWhere('remark', 'LIKE', "%$search%");
                    });
                }
            })
            ->select('daily_budget_items.*');

        if ($request->sort != null && $request->sort != '') {
            $sorts = explode(',', $request->input('sort', ''));

            foreach ($sorts as $sortColumn) {
                $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
                $sortColumn    = ltrim($sortColumn, '-');

                $data->orderBy($sortColumn, $sortDirection);
            }
        } else {
            $data->orderByDesc('daily_budget_items.processed_at');
        }

        if ($request->export) {
            if ($request->only_this_page) {
                $data = $data->skip(($request->page - 1) * $perPage)->take($perPage)->get();
            } else {
                $data = $data->get();
            }
        } else {
            $data = $data->paginate($perPage);

            // $items = $data->getCollection();

            // $items = collect($items)->map(function ($item) {
            //     return $item;
            // });

            // $data = $data->setCollection($items);
        }

        return $data;

    }

    public function findById($id)
    {
        return DailyBudgetItem::withTrashed(['category'])->findOrFail($id);
    }

    public function store(array $data)
    {
        $userId = auth()->id();
        $date   = Carbon::parse($data['processed_at']) ?? Carbon::now();

        $dailyBudget = DailyBudget::firstOrCreate(
            ['user_id' => $userId, 'date' => $date->format('Y-m-d')]
        );

        return DailyBudgetItem::create([
            'budget_id'    => $dailyBudget->id,
            'type'         => $data['type'],
            'category_id'  => $data['category_id'],
            'amount'       => $data['amount'],
            'remark'       => $data['remark'] ?? null,
            'processed_at' => $date->format('Y-m-d H:i:s'),
        ]);
    }

    public function update(DailyBudgetItem $item, array $data)
    {
        $userId = auth()->id();
        $date   = Carbon::parse($data['processed_at']) ?? Carbon::now();

        $dailyBudget = DailyBudget::firstOrCreate(
            ['user_id' => $userId, 'date' => $date->format('Y-m-d')]
        );

        $item->update([
            'budget_id'    => $dailyBudget->id,
            'type'         => $data['type'] ?? $item->type,
            'category_id'  => $data['category_id'] ?? $item->category_id,
            'amount'       => $data['amount'] ?? $item->amount,
            'remark'       => $data['remark'] ?? $item->remark,
            'processed_at' => $date ? $date->format('Y-m-d H:i:s') : $item->processed_at,
        ]);

        return $item;
    }

    public function delete(DailyBudgetItem $item)
    {
        $item->delete();
    }
}

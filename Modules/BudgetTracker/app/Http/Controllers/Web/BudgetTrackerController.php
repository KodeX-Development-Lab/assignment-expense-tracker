<?php
namespace Modules\BudgetTracker\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerBudgetRequest;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;
use Modules\BudgetTracker\Models\DailyBudgetItem;
use Modules\BudgetTracker\Services\BudgetTrackerService;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerServiceImpl;

class BudgetTrackerController extends Controller
{
    private BudgetTrackerService $budgetTrackerService;

    public function __construct(BudgetTrackerServiceImpl $budgetTrackerService)
    {
        $this->budgetTrackerService = $budgetTrackerService;
    }

    public function index(Request $request)
    {
        return view('budgets.index', [
            'budgets' => $this->budgetTrackerService->findByParams($request),
        ]);
    }

    public function create($type)
    {
        return view('budgets.create', [
            'categories' => BudgetTrackerCategory::where('type', $type)->get(),
        ]);
    }

    public function store(BudgetTrackerBudgetRequest $request)
    {
        $this->budgetTrackerService->store($request->all());

        return redirect()->route('budgets.index')->with('flash_message', 'Saved!');
    }

    public function edit($type, $id)
    {
        return view('budgets.edit', [
            'budget'       => DailyBudgetItem::with(['category'])->findOrFail($id),
            'categories' => BudgetTrackerCategory::where('type', $type)->get(),
        ]);
    }

    public function update(BudgetTrackerBudgetRequest $request, $id)
    {
        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->update($item, $request->all());

        return redirect()->route('budgets.index')->with('flash_message', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->delete($item);

        return redirect()->back()->with('flash_message', 'Deleted!');
    }
}

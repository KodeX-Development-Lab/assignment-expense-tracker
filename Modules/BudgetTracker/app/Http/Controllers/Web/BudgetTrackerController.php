<?php
namespace Modules\BudgetTracker\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerBudgetRequest;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;
use Modules\BudgetTracker\Models\DailyBudgetItem;
use Modules\BudgetTracker\Services\BudgetTrackerReportService;
use Modules\BudgetTracker\Services\BudgetTrackerService;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerReportServiceImpl;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerServiceImpl;

class BudgetTrackerController extends Controller
{
    private BudgetTrackerService $budgetTrackerService;
    private BudgetTrackerReportService $budgetTrackerReportService;

    public function __construct(BudgetTrackerServiceImpl $budgetTrackerService, BudgetTrackerReportServiceImpl $budgetTrackerReportService)
    {
        $this->budgetTrackerService       = $budgetTrackerService;
        $this->budgetTrackerReportService = $budgetTrackerReportService;
    }

    public function index(Request $request)
    {
        $brief = null;

        if ($request->start_date != null || $request->end_date != null) {
            $request->merge([
                'filter_type' => 'custom'
            ]);
            $brief = $this->budgetTrackerReportService->getTotalBriefBudget($request);
        } else {
            $brief = $this->budgetTrackerReportService->getAllBudgetsBrief();
        }

        return view('budgets.index', [
            'brief'   => $brief,
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
        $user = auth()->user();
        $budget = DailyBudgetItem::with(['category', 'budget'])->findOrFail($id);

        if($user->id != $budget->budget?->user_id) {
            return abort(403);
        }

        return view('budgets.edit', [
            'budget'     => $budget,
            'categories' => BudgetTrackerCategory::where('type', $type)->get(),
        ]);
    }

    public function update(BudgetTrackerBudgetRequest $request, $id)
    {
        $user = auth()->user();
        $budget = DailyBudgetItem::with(['category', 'budget'])->findOrFail($id);

        if($user->id != $budget->budget?->user_id) {
            return abort(403);
        }

        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->update($item, $request->all());

        return redirect()->route('budgets.index')->with('flash_message', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $budget = DailyBudgetItem::with(['category', 'budget'])->findOrFail($id);

        if($user->id != $budget->budget?->user_id) {
            return abort(403);
        }
        
        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->delete($item);

        return redirect()->back()->with('flash_message', 'Deleted!');
    }
}

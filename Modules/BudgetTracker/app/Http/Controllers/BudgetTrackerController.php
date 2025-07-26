<?php
namespace Modules\BudgetTracker\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerBudgetRequest;
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
        return response()->json([
            'status'  => true,
            'data'    => [
                'budgets' => $this->budgetTrackerService->findByParams($request),
            ],
            'message' => '',
        ], 200);
    }

    public function store(BudgetTrackerBudgetRequest $request)
    {
        $this->budgetTrackerService->store($request->all());

        return response()->json([
            'status'  => true,
            'data'    => [
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'budget' => $this->budgetTrackerService->findById($id),
            ],
            'message' => '',
        ], 200);
    }

    public function update(BudgetTrackerBudgetRequest $request, $id)
    {
        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->update($item, $request->all());

        return response()->json([
            'status'  => true,
            'data'    => [
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = $this->budgetTrackerService->findById($id);
        $this->budgetTrackerService->delete($item);

        return response()->json([], 204);
    }
}

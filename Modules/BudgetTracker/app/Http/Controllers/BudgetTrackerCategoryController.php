<?php
namespace Modules\BudgetTracker\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerCreateCategoryRequest;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerUpdateCategoryRequest;
use Modules\BudgetTracker\Services\BudgetTrackerCategoryService;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerCategoryServiceImpl;

class BudgetTrackerCategoryController extends Controller
{
    private BudgetTrackerCategoryService $budgetTrackerCategoryService;

    public function __construct(BudgetTrackerCategoryServiceImpl $budgetTrackerCategoryService)
    {
        $this->budgetTrackerCategoryService = $budgetTrackerCategoryService;
    }

    public function index(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'categories' => $this->budgetTrackerCategoryService->findByParams($request),
            ],
            'message' => '',
        ], 200);
    }

    public function store(BudgetTrackerCreateCategoryRequest $request)
    {
        $category = $this->budgetTrackerCategoryService->store($request->all());

        return response()->json([
            'status'  => true,
            'data'    => [
                'category' => $this->budgetTrackerCategoryService->findById($category->id),
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'category' => $this->budgetTrackerCategoryService->findById($id),
            ],
            'message' => '',
        ], 200);
    }

    public function update(BudgetTrackerUpdateCategoryRequest $request, $id)
    {
        $category = $this->budgetTrackerCategoryService->findById($id);

        $this->budgetTrackerCategoryService->update($category, $request->all());

        return response()->json([
            'status'  => true,
            'data'    => [
                'category' => $this->budgetTrackerCategoryService->findById($id),
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->budgetTrackerCategoryService->findById($id);
        $this->budgetTrackerCategoryService->delete($category);

        return response()->json([], 204);
    }
}

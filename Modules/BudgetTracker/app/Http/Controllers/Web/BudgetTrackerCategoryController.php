<?php
namespace Modules\BudgetTracker\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerCreateCategoryRequest;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerUpdateCategoryRequest;
use Modules\BudgetTracker\Models\BudgetTrackerCategory;
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
        $categories = $this->budgetTrackerCategoryService->findByParams($request);

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('categories.create', []);
    }

    public function store(BudgetTrackerCreateCategoryRequest $request)
    {
        $category = $this->budgetTrackerCategoryService->store($request->all());

        return redirect()->route('categories.index')->with('flash_message', 'Saved!');
    }

    public function edit($id)
    {
        return view('categories.edit', [
            'category' => BudgetTrackerCategory::findOrFail($id),
        ]);
    }

    public function update(BudgetTrackerUpdateCategoryRequest $request, $id)
    {
        $category = $this->budgetTrackerCategoryService->findById($id);

        $this->budgetTrackerCategoryService->update($category, $request->toArray());

        return redirect()->route('categories.index')->with('flash_message', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = BudgetTrackerCategory::findOrFail($id);

        $this->budgetTrackerCategoryService->delete($category);
        
        return redirect()->route('categories.index')->with('flash_message', 'Deleted!');
    }
}

<?php
namespace Modules\BudgetTracker\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BudgetTracker\Services\BudgetTrackerIconService;
use Modules\BudgetTracker\Services\Impl\BudgetTrackerIconServiceImpl;

class BudgetTrackerIconController extends Controller
{

    private BudgetTrackerIconService $budgetTrackerIconService;

    public function __construct(BudgetTrackerIconServiceImpl $budgetTrackerIconService)
    {
        $this->budgetTrackerIconService = $budgetTrackerIconService;
    }

    public function index(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'icons' => $this->budgetTrackerIconService->findByParams($request),
            ],
            'message' => '',
        ], 200);
    }

    public function show($id)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'icon' => $this->budgetTrackerIconService->findById($id),
            ],
            'message' => '',
        ], 200);
    }
}

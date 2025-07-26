<?php
namespace Modules\BudgetTracker\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\BudgetTracker\Http\Requests\BudgetTrackerConfigurationRequest;
use Modules\BudgetTracker\Models\BudgetTrackerConfiguration;

class BudgetTrackerConfigurationController extends Controller
{
    public function show()
    {
        $config = BudgetTrackerConfiguration::with(['currency'])->where('user_id', auth()->id())->first();

        return response()->json([
            'status'  => true,
            'data'    => [
                'config' => $config,
            ],
            'message' => '',
        ], 200);
    }

    public function update(BudgetTrackerConfigurationRequest $request)
    {
        BudgetTrackerConfiguration::updateOrCreate(
            ['user_id' => auth()->id()],
            ['currency_id' => $request->currency_id]
        );

        return response()->json([
            'status'  => true,
            'data'    => [
                'config' => BudgetTrackerConfiguration::with(['currency'])->where('user_id', auth()->id())->first(),
            ],
            'message' => 'Configuration saved successfully.',
        ], 200);
    }
}

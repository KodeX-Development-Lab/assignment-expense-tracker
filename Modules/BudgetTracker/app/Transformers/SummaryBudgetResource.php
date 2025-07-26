<?php
namespace Modules\BudgetTracker\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryBudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'label'   => $this->label,
            'income'  => $this->income,
            'expense' => $this->expense,
            'balance' => $this->balance,
        ];
    }
}

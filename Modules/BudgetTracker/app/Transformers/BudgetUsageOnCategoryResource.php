<?php
namespace Modules\BudgetTracker\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetUsageOnCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->category_id,
            'category'   => $this->category,
            'amount'     => $this->amount,
            'percentage' => $this->percentage,
        ];
    }
}

<?php
namespace Modules\BudgetTracker\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\BudgetTracker\Enums\BudgetTypes;

class BudgetTrackerUpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('budget_tracker_categories')
                    ->where(fn($query) =>
                        $query->where(function ($q) {
                            $q->where('is_default_by_system', 1)
                                ->orWhere('user_id', auth()->id());
                        })
                            ->whereNull('deleted_at')
                    )
                    ->ignore($this->category),
            ],
            'type'    => ['required', Rule::in(BudgetTypes::values())],
            'color'   => 'required|string|max:10',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}

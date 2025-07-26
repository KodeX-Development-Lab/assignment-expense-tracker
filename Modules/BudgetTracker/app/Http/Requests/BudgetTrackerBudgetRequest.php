<?php
namespace Modules\BudgetTracker\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\BudgetTracker\Enums\BudgetTypes;

class BudgetTrackerBudgetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type'         => ['required', Rule::in(BudgetTypes::values())],
            'category_id'  => 'required|exists:budget_tracker_categories,id',
            'amount'       => 'required|numeric|min:0',
            'remark'       => 'nullable|string|max:1000',
            'processed_at' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'type.in'            => 'The type must be either "income" or "expense".',
            'category_id.exists' => 'The selected category does not exist.',
            'amount.min'         => 'Amount must be a non-negative number.',
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

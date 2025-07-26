<?php
namespace Modules\BudgetTracker\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetTrackerConfigurationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'currency_id' => ['required', 'exists:currencies,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'currency_id.required' => "Currency is required",
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

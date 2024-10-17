<?php

namespace App\Http\Requests;

use App\Traits\Filterable;
use Illuminate\Foundation\Http\FormRequest;

class VegetableRequest extends FormRequest
{
    use Filterable;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:256',
            'classification_id' => 'exists:classifications,id',
            'description' => 'nullable|string',
            'edible' => 'required|boolean',
        ];
    }
}

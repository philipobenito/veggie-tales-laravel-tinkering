<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VegetableClassificationRequest extends FormRequest
{
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
        if ($this->isMethod($this::METHOD_GET)) {
            return [];
        }

        return [
            'name' => 'required|string|max:256|unique:vegetable_classifications,name,'
                . $this->route('vegetable_classification'),
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Field;
use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $fieldTypeIds = implode(',', array_keys(Field::getTypes()));
        $numberFieldTypeId = Field::TYPE_NUMBER;
        $selectFieldTypeId = Field::TYPE_SELECT;

        return [
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'type' => "required|integer|max:15|in:$fieldTypeIds",
            'subsection' => 'required|string|max:255',
            'subsection_sort_order' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'required_columns' => 'required|string|max:255|regex:/^\d+(,\d+)*$/',
            'minimum' => "nullable|numeric|prohibited_unless:type,$numberFieldTypeId" . ($this->filled('maximum') ? '|lt:maximum' : ''),
            'maximum' => "nullable|numeric|prohibited_unless:type,$numberFieldTypeId" . ($this->filled('minimum') ? '|gt:minimum' : ''),
            'select_options' => "nullable|string|max:255|regex:/^[^,]+(,[^,]+)*$/|required_if:type,$selectFieldTypeId|prohibited_unless:type,$selectFieldTypeId",
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'required_columns.regex' => 'The required columns field must be a comma-separated list of numbers (e.g., 1,2,3).',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'field_order' => explode(',', $this->field_order ?? ''),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $page = $this->route('page');
        $pageId = $page->id ?? null;

        $rules = [
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:pages,slug,$pageId",
            'column_count' => 'required|integer|min:1|max:12',
        ];

        if ($this->isMethod('patch')) {
            $rules = array_merge($rules, [
                'field_order' => 'sometimes|array',
                'field_order.*' => 'sometimes|integer|distinct|exists:fields,id',
            ]);
        }

        return $rules;
    }
}

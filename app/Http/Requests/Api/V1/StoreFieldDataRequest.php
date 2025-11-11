<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreFieldDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[] The validation rules.
     */
    public function rules(): array
    {
        return [
            'column' => 'required|integer|min:1',
            'fieldId' => 'required|integer|exists:fields,id',
            'value' => 'nullable|string|max:255',
            'pageDate' => 'required|date'
        ];
    }

    /**
     * Map the request attributes to the FieldData model attributes.
     *
     * @param array $otherAttributes
     * @return array<string, string> The mapped attributes for creating or updating FieldData.
     */
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'column' => 'column',
            'fieldId' => 'field_id',
            'value' => 'value',
            'pageDate' => 'page_date',
        ], $otherAttributes);

        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }
}

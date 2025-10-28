<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreFieldDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'column' => 'required|integer|min:1',
            'fieldId' => 'required|integer|exists:fields,id',
            'value' => 'nullable|string',
            'pageDate' => 'required|date'
        ];
    }

    public function mappedAttributes(array $otherAttributes = [])
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

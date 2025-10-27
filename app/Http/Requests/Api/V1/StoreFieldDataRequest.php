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
            'fieldId' => 'required|integer|exists:fields,id',
            'value' => 'required',
        ];
    }

    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'fieldId' => 'field_id',
            'value' => 'value',
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

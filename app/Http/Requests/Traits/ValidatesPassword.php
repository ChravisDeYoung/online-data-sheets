<?php

namespace App\Http\Requests\Traits;

trait ValidatesPassword
{
    /**
     * Get the validation rules that apply to the password field.
     *
     * @return string[]
     */
    protected function passwordRules(): array
    {
        return [
            'password' => 'required|string|min:7|max:255|confirmed',
        ];
    }
}

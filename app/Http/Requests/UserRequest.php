<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ValidatesPassword;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use ValidatesPassword;

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
     * @return string[]
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $userId = $user->id ?? null;

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$userId",
            'phone_number' => 'required|max:255|phone:CA',
            'roles' => 'required|array',
            'roles.*' => 'required|integer|distinct|exists:roles,id'
        ];

        if ($this->isMethod('post')) {
            $rules = array_merge($rules, $this->passwordRules());
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return auth()->check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     public function rules(): array
     {
         return [
            'name' => 'required|string|min:3|max:200',
            'email' => 'required|email|max:200|unique:users',
            'password' => 'required|string',
            'status' => 'required|boolean',
            // 'is_admin' => 'sometimes|boolean'
         ];
     }

     public function messages(): array
     {
         return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'status.required' => 'O status é obrigatório.'
         ];
     }


}

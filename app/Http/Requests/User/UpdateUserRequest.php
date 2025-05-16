<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // ou true se não houver necessidade de autenticação
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:200',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users')->ignore($this->usuario?->id)
            ],
            'password' => [
                'nullable',
                'string',
                'min:8'
            ],
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'status.required' => 'O status é obrigatório.'
        ];
    }
}

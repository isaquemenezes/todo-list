<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateUserLogoutRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

                'nova_senha' => [
                    'required',
                    'string',
                    'confirmed'

                ],

        ];
    }

    public function messages(): array
    {
        return [
            'nova_senha.confirmed' => 'A confirmação da nova senha não confere.',
            'nova_senha.required' => 'A senha deve é obrigatória.',
        ];
    }
}

<?php
namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResertRequest extends FormRequest
{
    public function authorize(): bool
    {

        return auth()->check();
    }

    public function rules(): array
    {
        return [

            'nova_senha' => [
                'required',
                'string'

            ],
        ];
    }

    public function messages(): array
    {
        return [

            'nova_senha.requerid' => 'A nova senha é obrigatória.',
        ];
    }
}

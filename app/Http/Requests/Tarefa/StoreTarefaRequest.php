<?php

namespace App\Http\Requests\Tarefa;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarefaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|min:3|max:255',
            'descricao' => 'nullable|string|max:500',
            'status' => 'required|in:pendente,concluida',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.min' => 'O título deve ter pelo menos 3 caracteres.',
            'titulo.max' => 'O título não pode passar de 255 caracteres.',
            'descricao.max' => 'A descrição não pode passar de 500 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "pendente" ou "concluída".',
        ];
    }

}

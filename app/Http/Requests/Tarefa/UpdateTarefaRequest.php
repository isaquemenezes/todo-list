<?php

namespace App\Http\Requests\Tarefa;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarefaRequest extends FormRequest
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
}

<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class ExemploRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'ativo' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('ativo')) {
            $this->merge([
                'ativo' => $this->boolean('ativo'),
            ]);

            return;
        }

        if ($this->isMethod('post')) {
            $this->merge(['ativo' => true]);
        }
    }
}

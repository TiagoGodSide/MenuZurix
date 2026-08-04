<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:80',
            ],

            'color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'banner_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome da categoria.',
            'name.max' => 'O nome deve possuir no máximo 100 caracteres.',

            'description.max' =>
                'A descrição deve possuir no máximo 500 caracteres.',

            'color.required' => 'Escolha uma cor.',
            'color.regex' => 'Informe uma cor hexadecimal válida.',

            'banner_image.image' =>
                'O banner precisa ser um arquivo de imagem.',

            'banner_image.mimes' =>
                'O banner deve ser JPG, PNG ou WebP.',

            'banner_image.max' =>
                'O banner deve possuir no máximo 3 MB.',

            'sort_order.required' => 'Informe a ordem de exibição.',
            'sort_order.integer' => 'A ordem deve ser um número inteiro.',
            'sort_order.min' => 'A ordem não pode ser negativa.',
        ];
    }
}
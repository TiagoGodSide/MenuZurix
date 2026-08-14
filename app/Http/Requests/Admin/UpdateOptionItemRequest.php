<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:120',
            ],

            'description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'additional_price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'max_quantity' => [
                'required',
                'integer',
                'min:1',
                'max:999',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:999999',
            ],

            'is_default' => [
                'nullable',
                'boolean',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'description' => 'descrição',
            'additional_price' => 'preço adicional',
            'max_quantity' => 'quantidade máxima',
            'sort_order' => 'ordem de exibição',
            'is_default' => 'item padrão',
            'is_active' => 'item ativo',
        ];
    }
}
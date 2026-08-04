<?php

namespace App\Http\Requests\Admin;

use App\Enums\BusinessStatus;
use App\Enums\BusinessType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'accepts_orders' => $this->boolean('accepts_orders'),
            'accepts_delivery' => $this->boolean('accepts_delivery'),
            'accepts_pickup' => $this->boolean('accepts_pickup'),

            'state' => $this->filled('state')
                ? mb_strtoupper((string) $this->input('state'))
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'legal_name' => [
                'nullable',
                'string',
                'max:180',
            ],

            'business_type' => [
                'required',
                Rule::enum(BusinessType::class),
            ],

            'status' => [
                'required',
                Rule::enum(BusinessStatus::class),
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'banner' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'whatsapp' => [
                'nullable',
                'string',
                'max:30',
            ],

            'instagram' => [
                'nullable',
                'string',
                'max:255',
            ],

            'facebook' => [
                'nullable',
                'string',
                'max:255',
            ],

            'zip_code' => [
                'nullable',
                'string',
                'max:15',
            ],

            'street' => [
                'nullable',
                'string',
                'max:255',
            ],

            'number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'complement' => [
                'nullable',
                'string',
                'max:255',
            ],

            'neighborhood' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:120',
            ],

            'state' => [
                'nullable',
                'string',
                'size:2',
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'minimum_order' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'default_delivery_fee' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'average_preparation_time' => [
                'nullable',
                'integer',
                'min:1',
                'max:1440',
            ],

            'accepts_orders' => [
                'required',
                'boolean',
            ],

            'accepts_delivery' => [
                'required',
                'boolean',
            ],

            'accepts_pickup' => [
                'required',
                'boolean',
            ],

            'pix_key' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pix_key_type' => [
                'nullable',
                Rule::in([
                    'cpf',
                    'cnpj',
                    'email',
                    'phone',
                    'random',
                ]),
            ],

            'primary_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'secondary_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'theme' => [
                'required',
                Rule::in([
                    'light',
                    'dark',
                ]),
            ],

            'timezone' => [
                'required',
                'timezone',
            ],

            'closed_message' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'paused_message' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'vacation_message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do negócio.',
            'business_type.required' => 'Escolha o tipo de negócio.',
            'business_type.enum' => 'O tipo de negócio selecionado é inválido.',
            'status.required' => 'Escolha o status do negócio.',
            'status.enum' => 'O status selecionado é inválido.',

            'logo.image' => 'O logotipo precisa ser uma imagem.',
            'logo.mimes' => 'O logotipo deve ser JPG, PNG ou WebP.',
            'logo.max' => 'O logotipo deve possuir no máximo 2 MB.',

            'banner.image' => 'O banner precisa ser uma imagem.',
            'banner.mimes' => 'O banner deve ser JPG, PNG ou WebP.',
            'banner.max' => 'O banner deve possuir no máximo 4 MB.',

            'email.email' => 'Informe um endereço de e-mail válido.',
            'state.size' => 'Informe a sigla do estado com duas letras.',

            'minimum_order.required' => 'Informe o pedido mínimo.',
            'minimum_order.min' => 'O pedido mínimo não pode ser negativo.',

            'default_delivery_fee.required' => 'Informe a taxa padrão.',
            'default_delivery_fee.min' => 'A taxa não pode ser negativa.',

            'primary_color.regex' => 'Informe uma cor principal válida.',
            'secondary_color.regex' => 'Informe uma cor secundária válida.',

            'timezone.timezone' => 'Informe um fuso horário válido.',
        ];
    }
}
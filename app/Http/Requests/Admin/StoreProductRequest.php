<?php

namespace App\Http\Requests\Admin;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sku' => $this->filled('sku')
                ? mb_strtoupper(trim((string) $this->input('sku')))
                : null,

            'is_featured' => $this->boolean('is_featured'),
            'is_product_of_the_day' => $this->boolean('is_product_of_the_day'),
            'is_available' => $this->boolean('is_available'),
            'is_sold_out' => $this->boolean('is_sold_out'),
            'is_active' => $this->boolean('is_active'),

            'sort_order' => $this->input('sort_order', 0),

            'promotional_price' => $this->filled('promotional_price')
                ? $this->input('promotional_price')
                : null,

            'preparation_time' => $this->filled('preparation_time')
                ? $this->input('preparation_time')
                : null,
        ]);
    }

    public function rules(): array
    {
        $business = $this->currentBusiness();

        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where(
                        fn ($query) => $query
                            ->where('business_id', $business->id)
                            ->where('is_active', true)
                    ),
            ],

            'sku' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products', 'sku')
                    ->where(
                        fn ($query) => $query
                            ->where('business_id', $business->id)
                    )
                    ->withoutTrashed(),
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'promotional_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
                'lt:price',
            ],

            'preparation_time' => [
                'nullable',
                'integer',
                'min:1',
                'max:1440',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:99999',
            ],

            'is_featured' => [
                'required',
                'boolean',
            ],

            'is_product_of_the_day' => [
                'required',
                'boolean',
            ],

            'is_available' => [
                'required',
                'boolean',
            ],

            'is_sold_out' => [
                'required',
                'boolean',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'images' => [
                'nullable',
                'array',
                'max:10',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Escolha uma categoria.',
            'category_id.exists' =>
                'A categoria selecionada não pertence a este negócio ou está inativa.',

            'sku.unique' => 'Já existe um produto com este SKU.',
            'sku.max' => 'O SKU deve possuir no máximo 50 caracteres.',

            'name.required' => 'Informe o nome do produto.',
            'name.max' => 'O nome deve possuir no máximo 150 caracteres.',

            'short_description.max' =>
                'A descrição curta deve possuir no máximo 255 caracteres.',

            'description.max' =>
                'A descrição deve possuir no máximo 5.000 caracteres.',

            'price.required' => 'Informe o preço do produto.',
            'price.numeric' => 'Informe um preço válido.',
            'price.min' => 'O preço não pode ser negativo.',

            'promotional_price.numeric' =>
                'Informe um preço promocional válido.',

            'promotional_price.lt' =>
                'O preço promocional deve ser menor que o preço normal.',

            'preparation_time.integer' =>
                'O tempo de preparo deve ser um número inteiro.',

            'preparation_time.min' =>
                'O tempo de preparo deve ser de pelo menos um minuto.',

            'images.array' => 'As imagens enviadas são inválidas.',
            'images.max' => 'Envie no máximo 10 imagens por vez.',
            'images.*.image' => 'Cada arquivo precisa ser uma imagem.',
            'images.*.mimes' => 'As imagens devem ser JPG, PNG ou WebP.',
            'images.*.max' => 'Cada imagem deve possuir no máximo 4 MB.',
        ];
    }

    protected function currentBusiness(): Business
    {
        /** @var Business|null $business */
        $business = $this->user()
            ?->businesses()
            ->orderBy('businesses.id')
            ->first();

        abort_if(
            $business === null,
            403,
            'Este usuário não está vinculado a um negócio.'
        );

        return $business;
    }
}
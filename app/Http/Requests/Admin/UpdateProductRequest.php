<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $business = $this->currentBusiness();
        $product = $this->route('product');

        $rules['sku'] = [
            'nullable',
            'string',
            'max:50',
            Rule::unique('products', 'sku')
                ->where(
                    fn ($query) => $query
                        ->where('business_id', $business->id)
                )
                ->ignore($product?->getKey())
                ->withoutTrashed(),
        ];

        return $rules;
    }
}
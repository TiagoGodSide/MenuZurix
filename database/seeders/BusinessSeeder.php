<?php

namespace Database\Seeders;

use App\Enums\BusinessStatus;
use App\Enums\BusinessType;
use App\Models\Business;
use App\Models\Category;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::updateOrCreate(
            [
                'slug' => 'restaurante-sabor-e-arte',
            ],
            [
                'name' => 'Restaurante Sabor & Arte',
                'business_type' => BusinessType::Restaurant,
                'status' => BusinessStatus::Open,
                'email' => 'contato@saborearte.com',
                'phone' => '(81) 0000-0000',
                'whatsapp' => '5581000000000',
                'city' => 'Recife',
                'state' => 'PE',
                'minimum_order' => 0,
                'default_delivery_fee' => 0,
                'accepts_orders' => true,
                'accepts_delivery' => true,
                'accepts_pickup' => true,
                'primary_color' => '#0d6efd',
                'secondary_color' => '#212529',
                'timezone' => 'America/Recife',
            ]
        );

        Category::query()
            ->whereNull('business_id')
            ->update([
                'business_id' => $business->id,
            ]);

        Product::query()
            ->whereNull('business_id')
            ->update([
                'business_id' => $business->id,
            ]);

        OptionGroup::query()
            ->whereNull('business_id')
            ->update([
                'business_id' => $business->id,
            ]);

        $admin = User::query()
            ->where('email', 'admin@menupro.com')
            ->first();

        if ($admin !== null) {
            $business->users()->syncWithoutDetaching([
                $admin->id => [
                    'role' => 'owner',
                ],
            ]);
        }
    }
}
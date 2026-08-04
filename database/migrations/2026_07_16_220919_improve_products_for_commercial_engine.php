<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remover índices globais
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table): void {
            $table->dropUnique('products_sku_unique');
            $table->dropUnique('products_slug_unique');
        });

        /*
        |--------------------------------------------------------------------------
        | Adicionar novos campos
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table): void {
            $table->boolean('is_available')
                ->default(true)
                ->after('is_product_of_the_day');

            $table->boolean('is_sold_out')
                ->default(false)
                ->after('is_available');

            $table->softDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | Tornar business_id obrigatório
        |--------------------------------------------------------------------------
        */

        DB::statement(
            'ALTER TABLE products
             MODIFY business_id BIGINT UNSIGNED NOT NULL'
        );

        /*
        |--------------------------------------------------------------------------
        | Unicidade por negócio
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table): void {
            $table->unique(
                ['business_id', 'slug'],
                'products_business_slug_unique'
            );

            $table->unique(
                ['business_id', 'sku'],
                'products_business_sku_unique'
            );

            $table->index(
                [
                    'business_id',
                    'is_active',
                    'is_available',
                    'is_sold_out',
                ],
                'products_commercial_status_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropIndex(
                'products_commercial_status_index'
            );

            $table->dropUnique(
                'products_business_slug_unique'
            );

            $table->dropUnique(
                'products_business_sku_unique'
            );

            $table->dropSoftDeletes();

            $table->dropColumn([
                'is_available',
                'is_sold_out',
            ]);
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->unique('slug');
            $table->unique('sku');
        });

        DB::statement(
            'ALTER TABLE products
             MODIFY business_id BIGINT UNSIGNED NULL'
        );
    }
};
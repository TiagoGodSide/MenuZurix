<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_group_product', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('option_group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('min_choices')
                ->default(0);

            $table->unsignedSmallInteger('max_choices')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->unique([
                'product_id',
                'option_group_id',
            ]);

            $table->index([
                'product_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_group_product');
    }
};
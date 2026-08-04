<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('sku', 50)
                ->nullable()
                ->unique();

            $table->string('name', 150);

            $table->string('slug', 180)
                ->unique();

            $table->string('short_description', 255)
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->decimal('price', 10, 2);

            $table->decimal('promotional_price', 10, 2)
                ->nullable();

            $table->unsignedSmallInteger('preparation_time')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('is_product_of_the_day')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index([
                'category_id',
                'is_active',
                'sort_order',
            ]);

            $table->index([
                'is_featured',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
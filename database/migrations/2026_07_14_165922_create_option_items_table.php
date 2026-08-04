<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_items', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('option_group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name', 120);

            $table->string('description', 255)
                ->nullable();

            $table->decimal('additional_price', 10, 2)
                ->default(0);

            $table->unsignedSmallInteger('max_quantity')
                ->default(1);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_default')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index([
                'option_group_id',
                'is_active',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_items');
    }
};
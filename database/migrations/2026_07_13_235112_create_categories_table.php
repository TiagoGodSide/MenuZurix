<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();

            $table->uuid('uuid')
                ->unique();

            $table->string('name', 100);

            $table->string('slug', 120)
                ->unique();

            $table->string('description', 500)
                ->nullable();

            $table->string('icon', 80)
                ->nullable();

            $table->string('color', 7)
                ->default('#0d6efd');

            $table->string('banner_image')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index([
                'is_active',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name', 120);

            $table->string('description', 255)
                ->nullable();

            $table->enum('selection_type', [
                'single',
                'multiple',
            ])->default('multiple');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index([
                'is_active',
                'name',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_groups');
    }
};
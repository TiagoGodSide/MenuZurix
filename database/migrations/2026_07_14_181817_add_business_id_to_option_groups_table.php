<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('option_groups', function (Blueprint $table): void {
            $table->foreignId('business_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->restrictOnDelete();

            $table->index([
                'business_id',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('option_groups', function (Blueprint $table): void {
            $table->dropIndex([
                'business_id',
                'is_active',
            ]);

            $table->dropConstrainedForeignId('business_id');
        });
    }
};
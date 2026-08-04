<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name', 150);
            $table->string('legal_name', 180)->nullable();

            $table->string('slug', 180)->unique();

            $table->string('business_type', 40)
                ->default('other');

            $table->string('status', 30)
                ->default('closed');

            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();

            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

            $table->string('zip_code', 15)->nullable();
            $table->string('street')->nullable();
            $table->string('number', 30)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city', 120)->nullable();
            $table->string('state', 2)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->decimal('minimum_order', 10, 2)
                ->default(0);

            $table->decimal('default_delivery_fee', 10, 2)
                ->default(0);

            $table->unsignedSmallInteger('average_preparation_time')
                ->nullable();

            $table->boolean('accepts_orders')
                ->default(true);

            $table->boolean('accepts_delivery')
                ->default(true);

            $table->boolean('accepts_pickup')
                ->default(true);

            $table->string('pix_key')->nullable();
            $table->string('pix_key_type', 30)->nullable();

            $table->string('primary_color', 7)
                ->default('#0d6efd');

            $table->string('secondary_color', 7)
                ->default('#212529');

            $table->string('theme', 20)
                ->default('light');

            $table->string('timezone', 60)
                ->default('America/Recife');

            $table->text('closed_message')->nullable();
            $table->text('paused_message')->nullable();
            $table->text('vacation_message')->nullable();

            $table->timestamps();

            $table->index([
                'status',
                'accepts_orders',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
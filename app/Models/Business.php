<?php

namespace App\Models;

use App\Enums\BusinessStatus;
use App\Enums\BusinessType;
use Database\Factories\BusinessFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Business extends Model
{
    /** @use HasFactory<BusinessFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'legal_name',
        'slug',
        'business_type',
        'status',
        'logo_path',
        'banner_path',
        'email',
        'phone',
        'whatsapp',
        'instagram',
        'facebook',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'latitude',
        'longitude',
        'minimum_order',
        'default_delivery_fee',
        'average_preparation_time',
        'accepts_orders',
        'accepts_delivery',
        'accepts_pickup',
        'pix_key',
        'pix_key_type',
        'primary_color',
        'secondary_color',
        'theme',
        'timezone',
        'closed_message',
        'paused_message',
        'vacation_message',
    ];

    protected function casts(): array
    {
        return [
            'business_type' => BusinessType::class,
            'status' => BusinessStatus::class,
            'minimum_order' => 'decimal:2',
            'default_delivery_fee' => 'decimal:2',
            'average_preparation_time' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'accepts_orders' => 'boolean',
            'accepts_delivery' => 'boolean',
            'accepts_pickup' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Business $business): void {
            if (blank($business->uuid)) {
                $business->uuid = (string) Str::uuid7();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function optionGroups(): HasMany
    {
        return $this->hasMany(OptionGroup::class);
    }

    public function isOpen(): bool
    {
        return $this->status === BusinessStatus::Open
            && $this->accepts_orders;
    }
}
<?php

namespace App\Models;

use Database\Factories\OptionItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OptionItem extends Model
{
    /** @use HasFactory<OptionItemFactory> */
    use HasFactory;

    protected $fillable = [
        'option_group_id',
        'name',
        'description',
        'additional_price',
        'max_quantity',
        'sort_order',
        'is_default',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'additional_price' => 'decimal:2',
            'max_quantity' => 'integer',
            'sort_order' => 'integer',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (OptionItem $item): void {
            if (blank($item->uuid)) {
                $item->uuid = (string) Str::uuid7();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function optionGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function isFree(): bool
    {
        return (float) $this->additional_price === 0.0;
    }
}
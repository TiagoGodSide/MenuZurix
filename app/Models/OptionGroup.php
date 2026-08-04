<?php

namespace App\Models;

use Database\Factories\OptionGroupFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OptionGroup extends Model
{
    /** @use HasFactory<OptionGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'selection_type',
        'is_active',
        'business_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (OptionGroup $group): void {
            if (blank($group->uuid)) {
                $group->uuid = (string) Str::uuid7();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function items(): HasMany
    {
        return $this->hasMany(OptionItem::class)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'min_choices',
                'max_choices',
                'sort_order',
            ])
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
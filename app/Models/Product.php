<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'business_id',
        'category_id',
        'sku',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'promotional_price',
        'preparation_time',
        'sort_order',
        'is_featured',
        'is_product_of_the_day',
        'is_available',
        'is_sold_out',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'promotional_price' => 'decimal:2',
            'preparation_time' => 'integer',
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
            'is_product_of_the_day' => 'boolean',
            'is_available' => 'boolean',
            'is_sold_out' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product): void {
            if (blank($product->uuid)) {
                $product->uuid = (string) Str::uuid7();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', true);
    }

    public function optionGroups(): BelongsToMany
    {
        return $this->belongsToMany(OptionGroup::class)
            ->withPivot([
                'min_choices',
                'max_choices',
                'sort_order',
            ])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('is_available', true)
            ->where('is_sold_out', false);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function hasPromotion(): bool
    {
        return $this->promotional_price !== null
            && (float) $this->promotional_price > 0
            && (float) $this->promotional_price < (float) $this->price;
    }

    public function currentPrice(): float
    {
        return $this->hasPromotion()
            ? (float) $this->promotional_price
            : (float) $this->price;
    }

    public function canBePurchased(): bool
    {
        return $this->is_active
            && $this->is_available
            && ! $this->is_sold_out;
    }
}
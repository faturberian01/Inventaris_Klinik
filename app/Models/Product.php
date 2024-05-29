<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'last_new_stocks' => 'integer',
        'type' => ProductType::class,
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        return $query->when(
            $filters['q'] ?? false,
            fn (Builder $q, $value) => $q
                ->where('name', 'LIKE', "%$value%")
                ->orWhere('description', 'LIKE', "%$value%")
        );
    }

    public function getPhoto()
    {
        return asset('storage/' . $this->photo);
    }

    public static function genCode()
    {
        return sprintf('PRD-%s-%s', Str::random(4), Str::random(5));
    }

    public function productStocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
}

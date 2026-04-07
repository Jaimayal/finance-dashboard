<?php

namespace App\Models;

use App\Enums\RateType;
use Database\Factories\RateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['institution_id', 'name', 'annual_rate', 'type', 'min_amount', 'max_amount', 'days', 'sort_order', 'description', 'frecuency'])]
class Rate extends Model
{
    /** @use HasFactory<RateFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => RateType::class,
        ];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class);
    }
}

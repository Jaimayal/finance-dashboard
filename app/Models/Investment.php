<?php

namespace App\Models;

use Database\Factories\InvestmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'rate_id', 'name', 'color', 'amount', 'start_date', 'end_date'])]
class Investment extends Model
{
    /** @use HasFactory<InvestmentFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class);
    }
}

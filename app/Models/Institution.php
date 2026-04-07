<?php

namespace App\Models;

use Database\Factories\InstitutionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'logo'])]
class Institution extends Model
{
    /** @use HasFactory<InstitutionFactory> */
    use HasFactory;

    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }
}

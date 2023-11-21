<?php

namespace App\DelegationList\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delegation extends Model
{
    use HasFactory;
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

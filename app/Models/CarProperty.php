<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarProperty extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];


    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}

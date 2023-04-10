<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_point_id',
        'destination_point_id',
        'bus_id',
    ];

    public function startingStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'start_point_id');
    }
    public function destinationStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'destination_point_id');
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
}

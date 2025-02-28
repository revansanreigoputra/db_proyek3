<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = [
        'name',
        'category',
        'event_id',
        'price',
        'stock',
        'day_type',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}

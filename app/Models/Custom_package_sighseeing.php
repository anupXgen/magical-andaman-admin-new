<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom_package_sighseeing extends Model
{
    use HasFactory;
    protected $table = 'custom_package_sighseeing';

    protected $fillable = [
        'custom_package_id',
        'itinerary_day',
        'sightseeing_id',
        'status',
        'delete',
        'created_at',
        'created_by',
    ];
    public function sightseeing()
    {
        return $this->belongsTo(Sightseeings::class);
    }
}

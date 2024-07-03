<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sightseeings extends Model
{
    use HasFactory;
    protected $table = 'sight_seeings';

    protected $fillable = [
        'title',
        'subtitle',
        'location_id',
        'status',
        'delete',
        'created_at',
        'created_by',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom_package_activity extends Model
{
    use HasFactory;
    protected $table = 'custom_package_activity';

    protected $fillable = [
        'user_id',
        'custom_package_id',
        'itinerary_day',
        'activity_id',
        'status',
        'created_at',
        'created_by',
        'delete',
    ];
    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_price extends Model
{
    use HasFactory;
    protected $table = 'hotel_price';
    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'category_id',
        'cp',
        'map',
        'ap',
        'ep',
        'created_at',
        'created_by',
        'status',
        'delete',
    ];

    public function hotel_cat()
    {
        return $this->belongsTo(Hotel_category::class, 'category_id');
    }
}

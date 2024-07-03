<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    protected $table="cars";
    public $timestamps = false;
    protected $fillable =[
        'title',
        'subtitle',
        'car_category',
        'seater',
        'ac',
        'price_per_hour',
        'car_image',
        'status',
        
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_category extends Model
{
    use HasFactory;
    protected $table="car_category";
    protected $fillable =[
        'category_title',
        'status',
        
    ];
}

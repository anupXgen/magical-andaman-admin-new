<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = 'enquiries';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'travel_month',
        'travel_duration',
        'travel_person',
        'travel_starting_price',
        'travel_ending_price',
        'comments',
        'created_at',
        'updated_at',
        'status',
        'delete',
    ];
}

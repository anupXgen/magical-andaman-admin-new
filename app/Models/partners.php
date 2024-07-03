<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partners extends Model
{
    use HasFactory;
    protected $table = 'partners';

    protected $fillable = [
        'company_name',
        'address',
        'company_logo',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'is_deleted',
        'status',
    ];
}

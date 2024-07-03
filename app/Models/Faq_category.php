<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq_category extends Model
{
    use HasFactory;
    protected $table = 'faq_category';

    protected $fillable = [
        'category_title',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'delete',
        'status',
    ];
}

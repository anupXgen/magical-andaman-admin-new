<?php

namespace Modules\Achievement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;
    protected $table = 'achievements';
    protected $fillable = [
        'title', 'subtitle','path','size', 'created_at', 'updated_at', 'status', 'delete'
    ];
    
}

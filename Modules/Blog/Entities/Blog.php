<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'title', 'subtitle', 'author_name', 'path', 'size', 'created_at', 'updated_at', 'status', 'delete'
    ];
}

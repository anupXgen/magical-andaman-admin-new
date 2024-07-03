<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'faq';

    protected $fillable = [
        'questions',
        'answers',
        'related_module',
        'faq_category',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'delete',
        'status',
    ];
    public function faq_cat()
    {
        return $this->belongsTo(Faq_category::class, 'faq_category');
    }
}

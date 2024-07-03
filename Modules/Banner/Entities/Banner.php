<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banners';
    protected $fillable = [
        'title', 'subtitle', 'button_text', 'button_link', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'delete'
    ];
    public function bannerimage()
    {
        return $this->hasMany(Bannerimage::class, 'parent_id');
    }
}

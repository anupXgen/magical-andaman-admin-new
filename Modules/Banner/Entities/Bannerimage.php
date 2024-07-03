<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bannerimage extends Model
{
    use HasFactory;
    protected $table = 'banner_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function banner()
    {
        return $this->belongsTo(Banner::class, 'parent_id');
    }
}

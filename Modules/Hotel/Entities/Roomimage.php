<?php

namespace Modules\hotel\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class roomimage extends Model
{
    use HasFactory;
    protected $table = 'room_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function room()
    {
        return $this->belongsTo(room::class, 'parent_id');
    }
}

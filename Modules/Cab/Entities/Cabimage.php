<?php

namespace Modules\Cab\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabimage extends Model
{
    use HasFactory;
    protected $table = 'cab_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function cab()
    {
        return $this->belongsTo(cab::class, 'parent_id');
    }
}

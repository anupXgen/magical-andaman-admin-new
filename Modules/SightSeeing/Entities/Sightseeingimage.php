<?php

namespace Modules\SightSeeing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sightseeingimage extends Model
{
    use HasFactory;
    protected $table = 'sight_seeing_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function sightseeing()
    {
        return $this->belongsTo(Sightseeing::class, 'parent_id');
    }
}

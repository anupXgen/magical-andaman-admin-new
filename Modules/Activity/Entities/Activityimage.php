<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activityimage extends Model
{
    use HasFactory;
    protected $table = 'activity_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }
}

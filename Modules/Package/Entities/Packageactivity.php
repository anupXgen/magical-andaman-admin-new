<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Activity\Entities\Activity;

class Packageactivity extends Model
{
    use HasFactory;
    protected $table = 'package_activitys';
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'activity_id', 'status', 'delete'
    ];
    // public function itineraryimage()
    // {
    //     return $this->hasMany(Itineraryimage::class, 'parent_id');
    // }
    public function package()
    {
        return $this->hasMany(Packageactivity::class, 'package_id');
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}

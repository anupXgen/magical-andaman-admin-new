<?php

namespace Modules\Activity\Entities;

use App\Models\Activity_category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Destination\Entities\Destination;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activitys';
    protected $fillable = [
        'title', 'subtitle','activity_category', 'price', 'location_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'delete'
    ];
    public function activityimage()
    {
        return $this->hasMany(Activityimage::class, 'parent_id');
    }
    public function package()
    {
        return $this->hasOne(Packageactivity::class, 'activity_id');
    }
    public function location()
    {
        return $this->belongsTo(Destination::class, 'location_id');
    }
    public function activity_cat()
    {
        return $this->belongsTo(Activity_category::class, 'activity_category');
    }
}

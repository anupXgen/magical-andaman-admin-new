<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packagefeature extends Model
{
    use HasFactory;
    protected $table = 'package_features';
    public $timestamps = false;
    protected $fillable = [
        'parent_id','night_stay','transport','activity','ferry'
    ];
    public function package()
    {
        return $this->belongsTo(package::class, 'parent_id');
    }
}

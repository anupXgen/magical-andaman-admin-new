<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packageimage extends Model
{
    use HasFactory;
    protected $table = 'package_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function package()
    {
        return $this->belongsTo(package::class, 'parent_id');
    }
}

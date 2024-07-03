<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packagestyle extends Model
{
    use HasFactory;
    protected $table = 'package_styles';
    public $timestamps = false;
    protected $fillable = [
        'package_id','package_style_id'
    ];
    public function package()
    {
        return $this->belongsTo(package::class, 'package_id');
    }

    public function style_details()
    {
        return $this->belongsTo(Packagestylemaster::class, 'package_style_id');
    }
}


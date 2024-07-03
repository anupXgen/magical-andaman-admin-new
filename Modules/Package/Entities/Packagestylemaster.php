<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packagestylemaster extends Model
{
    use HasFactory;
    protected $table = 'package_styles_master';
    public $timestamps = false;
    protected $fillable = [
        'status', 'title', 'created_at'
    ];
    public function package()
    {
        return $this->belongsTo(package::class, 'package_id');
    }
}

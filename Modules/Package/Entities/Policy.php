<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends Model
{
    use HasFactory;
    protected $table = 'policys';
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'title', 'subtitle'
    ];
    public function package()
    {
        return $this->hasMany(Policy::class, 'package_id');
    }
}

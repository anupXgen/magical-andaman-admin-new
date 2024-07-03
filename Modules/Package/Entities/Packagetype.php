<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packagetype extends Model
{
    use HasFactory;
    protected $table = 'package_types';
    public $timestamps = false;
    protected $fillable = [
        'title','subtitle','status','delete'
    ];
    public function typeprice()
    {
        return $this->belongsTo(Typeprice::class, 'parent_id','id');
    }
}

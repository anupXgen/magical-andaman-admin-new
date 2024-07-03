<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Typeprice extends Model
{
    use HasFactory;
    protected $table = 'type_prices';
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'type_id', 'subtitle', 'cp_plan', 'map_with_dinner', 'actual_price'
    ];
    public function typepriceimage()
    {
        return $this->hasMany(Typepriceimage::class, 'parent_id');
    }
    public function packagetype()
    {
        return $this->hasOne(Packagetype::class, 'id', 'type_id');
    }
    public function package()
    {
        return $this->hasMany(Typeprice::class, 'package_id');
    }
}

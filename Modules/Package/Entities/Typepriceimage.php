<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Typepriceimage extends Model
{
    use HasFactory;
    protected $table = 'type_price_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function typeprice()
    {
        return $this->belongsTo(Typeprice::class, 'parent_id');
    }
}

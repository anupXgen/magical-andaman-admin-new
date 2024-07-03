<?php

namespace Modules\Contactus\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use app\models\Webuser;

class Contactus extends Model
{
    use HasFactory;
    protected $table = 'contactus';
    protected $fillable = [
        'user_id', 'package_id', 'name', 'email', 'mobile', 'message', 'admin_responce_at', 'created_at', 'updated_at', 'status', 'delete'
    ];
    // public function webuser()
    // {
    //     return $this->hasOne(Webuser::class, 'user_id');
    // }
}

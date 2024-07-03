<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class Webuser extends Authenticatable
{
    //use HasFactory, Notifiable, HasRoles;
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'web_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'delete',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function contactusWebuser()
    // {
    //     return $this->belongsTo(Contactus::class, 'user_id', 'id');
    // }
}

<?php

namespace Modules\AgentLogin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AgentLogin\Database\factories\AgentLoginFactory;

class AgentLogin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'pan_number',
        'address',
        'email_verified_at',
        'password',
    ];
    
    // protected static function newFactory(): AgentLoginFactory
    // {
    //     //return AgentLoginFactory::new();
    // }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public static $role = "";

    public static $roles = [
        "1"=>"Student",
        "2"=>"Teacher"
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

    public static function getUser($token){
        return User::where("api_token",$token)->first();
    }

    public function api_tokens()
    {
        return $this->belongsToMany(ApiToken::class,"user_token","user_id","token_id","id","id");
    }

    public static function isAuth($token)
    {
       return ApiToken::where("token",$token)->exists();
    }

    public static function getUserRole($mask){
        collect(self::$roles)->keys()->each(function ($key) use ($mask){
            if(($mask & sprintf("%08d",decbin($key))) == (sprintf("%08d",decbin($key)))){
               self::$role = self::$roles[$key];
            }
        });

        return self::$role;
    }


}

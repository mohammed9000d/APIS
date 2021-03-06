<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function roles(){
        $roles =[
            'name' => 'required|string|min:3|max:10',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
        ];

        return $roles ;
    }

    public static function roleslogin(){
        $roles =[
            'email' => 'required|email|exists:users',
            'password' => 'required|min:3',
        ];

        return $roles ;
    }


}

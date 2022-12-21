<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'road',
        'postal_code',
        'city',
        'admin'
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

    public function setPasswordAttribute($password)
    {
        $this->attributes['password']=bcrypt($password);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product')->with('productCat');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order')->with('merchant');
    }

    public function merchantOrders()
    {
        return $this->hasMany('App\Models\Order', 'merchant_id')->with('user');
    }

    public function baskets()
    {
        return $this->hasMany('App\Models\Basket')->with('product');
    }
}

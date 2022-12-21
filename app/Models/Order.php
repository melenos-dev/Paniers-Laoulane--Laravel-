<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable=['user_id', 'merchant_id', 'status', 'total_price'];

	public function products()
	{
		return $this->belongsToMany('App\Models\Product')->withPivot('quantity');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
    
	public function merchant()
	{
		return $this->belongsTo('App\Models\User', 'merchant_id');
	}
}
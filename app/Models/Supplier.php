<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model 
{
	protected $fillable=['supplier_name', 'img', 'description', 'user_id'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
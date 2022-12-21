<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable=['product_name', 'img', 'product_price', 'product_total_price', 'product_weight', 'description', 'user_id', 'category_id', 'slug', 'product_quantity', 'state'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function baskets()
	{
		return $this->hasMany('App\Models\Basket');
	}

	public function productCat()
	{
		return $this->belongsTo('App\Models\ProductCat', 'category_id');
	}

	public function priceRender()
	{
		return round($this->product_price * $this->product_weight, 2);
	}

	public function getQuantity()
	{
		$baskets = $this->hasMany('App\Models\Basket');
		$total_quantity_baskets = $baskets->sum('quantity');
		$total = $this->product_quantity - $total_quantity_baskets;
		return $total;
	}

	public function getPriceByQuantity()
	{
		$quantity = $this->pivot->quantity;
		$price = ($this->product_total_price == '') ? $this->priceRender() : $this->product_total_price;
		return $price * $quantity;
	}

	public function orders()
	{
		return $this->belongsToMany('App\Models\Order');
	}
}
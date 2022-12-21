<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
	protected $fillable=['product_id', 'user_id', 'quantity'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function product()
	{
		return $this->belongsTo('App\Models\Product', 'product_id')->with('productCat');
	}

	public function getTotalPrice()
	{
		$price = 0;
		foreach($this->user->baskets as $baskets)
		{
			$price += $baskets->getPriceByQuantity();
		}
		return $price;
	}

	public function getTotalPricePerMerchant($merchant_id)
	{
		$price = 0;
		foreach($this->user->baskets->where('product.user_id', '=', $merchant_id) as $baskets)
		{
			$price += $baskets->getPriceByQuantity();
		}
		return $price;
	}

	public function getPriceByQuantity()
	{
		$quantity = $this->quantity;
		$price = ($this->product->product_total_price == '') ? $this->product->priceRender() : $this->product->product_total_price;
		return $price * $quantity;
	}
}
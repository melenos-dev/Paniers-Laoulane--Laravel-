<?php
namespace App\Management;
use App\Models\Order;
use Mail;

class OrderManagement extends ResourceManagement
{
	protected $order;

	public function __construct (Order $order)
	{
		$this->model=$order;
	}	

	public function getByUserId()
	{
		$orders = $this->model->where('user_id', '=', \Auth::user()->id)->get();
		return $orders;
	}

	public function getById($id)
	{
		return $this->model->with('user')->findOrFail($id);
	}

	public function create($user_id, $baskets)
	{
        $merchantsOfBaskets = $baskets->groupBy('product.user_id'); // Find the merchants by the creators of the products
        foreach($merchantsOfBaskets as $basket)
        {
            $order = new $this->model([
                'user_id' => $user_id,
                'merchant_id' => $basket[0]['product']['user_id'],
				'total_price' => $basket[0]->getTotalPricePerMerchant($basket[0]['product']['user_id'])
            ]);
            $order->save();	
			$products_basket = $baskets->where('product.user_id', '=', $order->merchant_id);

            Mail::send('emails/new_order', array('from' => $order->user->lastname.' '.$order->user->firstname, 'products_basket' => $products_basket, 'total_price' => $order->total_price), function($message) use($order)
            {
                $message->to($order->merchant->email)->subject(__('New order'));
            });

            $this->storePivots($order, $products_basket); // For each order, select the products that was created by the actual order merchant

        }
	}

	public function storePivots($order, $baskets) // Store the products order, actualise the product_quantity and remove the basket.
	{
        foreach($baskets as $basket)
        {
            $order->products()->attach($basket->product->id, ['quantity' => $basket->quantity]);
            $basket->product->product_quantity -= $basket->quantity;
            $basket->product->save();
            $basket->destroy($basket->id);
        }

	}

    public function getMerchantOrders($user_id)
    {
        return $this->model->products();
    }

	public function edit($id, $inputs)
	{
		$this->update($id, $inputs);	
	}
}
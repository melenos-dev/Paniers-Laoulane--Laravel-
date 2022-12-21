<?php
namespace App\Management;
use App\Models\Basket;
use Illuminate\Support\Str;

class BasketManagement extends ResourceManagement
{
	protected $basket;

	public function __construct (basket $basket)
	{
		$this->model=$basket;
	}

	public function getByProductId($user_id, $product_id)
	{
		$basket = $this->model->where([
                                ['user_id', '=', $user_id],
                                ['product_id', '=', $product_id],
                            ]);
		if($basket->count() > 0)
			return $basket->first();
		return false;
	}

    public function productAlreadyInBasket($user_id, $product_id)
    {
        if($basket = $this->getByProductId($user_id, $product_id))
            return $basket;
        return false;
    }

	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

	public function save($inputs)
	{
        if(!$basket=$this->productAlreadyInBasket($inputs['user_id'], $inputs['product_id']))
		    $this->store($inputs);
        else
        {
            $inputs['quantity'] = $basket->quantity + $inputs['quantity'];
            $this->edit($basket->id, $inputs);
        }
            
	}

	public function edit($id, $inputs)
	{
		$this->update($id, $inputs);	
	}
}
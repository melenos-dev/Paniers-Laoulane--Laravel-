<?php
namespace App\Management;
use App\Models\Delivery;

class DeliveryManagement extends ResourceManagement
{
	protected $delivery;

	public function __construct (Delivery $delivery)
	{
		$this->model=$delivery;
	}

    public function getLasts($limit)
    {
        return $this->model->orderBy('deliveries.date', 'desc')->skip(0)->take($limit)->get(); 
    }
}
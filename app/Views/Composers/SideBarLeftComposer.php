<?php
namespace App\Views\Composers;

use App\Management\DeliveryManagement;
use App\Management\ProductCatManagement;
use Illuminate\View\View;

class SideBarLeftComposer
{
    protected $deliveryManagement;
    protected $nbLasts = 2;

     /**
     * Create a new profile composer.
     *
     * @param  \App\Management\DeliveryManagement  $deliveryManagement
     * @return void
     */
    public function __construct(DeliveryManagement $deliveryManagement, ProductCatManagement $productCatManagement)
    {
        $this->deliveryManagement = $deliveryManagement;
        $this->productCatManagement = $productCatManagement;
    }

    public function compose(View $view)
    {   
        $view->with('deliveries', $this->deliveryManagement->getLasts($this->nbLasts));
        $view->with('categories', $this->productCatManagement->getAllParents());
        $view->with('sideBarLeft', true);
    }
}
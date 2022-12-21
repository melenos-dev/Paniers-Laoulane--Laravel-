<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\UserManagement;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Management\DeliveryManagement;
use App\Management\SupplierManagement;
use App\Management\ProductManagement;
use App\Http\Requests\DeliveryRequest;

class AdminController extends Controller
{
	protected $userManagement;
    protected $deliveryManagement;
    protected $supplierManagement;
    protected $nbLastsDelivery = 2;

    public function __construct(UserManagement $userManagement, DeliveryManagement $deliveryManagement)
    {
        $this->userManagement = $userManagement;
        $this->deliveryManagement = $deliveryManagement;
    }

    public function index()
    {
        $users=$this->userManagement->getPaginate(12);
        $deliveriesA = $this->deliveryManagement->getLasts($this->nbLastsDelivery);
        $links=$users->setPath('')->render();
        return view ('admin.index', compact('users', 'links', 'deliveriesA'));
    }

    public function destroyDelivery($id)
    {
        $this->deliveryManagement->destroy($id);
        return redirect()->back()->with('ok', 'Livraison supprimée, tant pis pour eux ! ;p');
    }

    public function addDelivery(DeliveryRequest $request)
    {
        if($this->deliveryManagement->store($request->validated()))
            return redirect()->back()->with('ok', 'Livraison ajoutée avec succès ! Congratulation ! أتقنه');
    }

    public function editUser($id)
    {
        $user=$this->userManagement->getById($id);
        return view('admin.user.edit', compact('user'));
    }

    public function destroyUser($id, SupplierManagement $supplierManagement, ProductManagement $productManagement)
    {
        $user = $this->userManagement->getById($id);
        if($user)
        {
            $user->orders->each(function ($order) {
                foreach($order->products as $product)
                    $order->products()->detach($product->id);
                $order->delete(); // If the user have orders registered, delete all orders
            });

            if($user->admin != 0)
            {
                $user->baskets->each(function ($basket) {
                    $basket->delete(); // If the user have baskets registered, delete all baskets
                });

                $user->products->each(function ($product) use($productManagement){
                    $productManagement->reallyDestroy(config('app.productPath'), $product->id); // If this user has created some products, delete all these products
                });
    
                $supplier = $supplierManagement->getByUserId($id);
                if($supplier) // If the user has created a supplier page, delete this page
                    $supplierManagement->delete(config('app.supplierPath'), $supplier->id); 
            }
            else
            {

                $user->baskets->each(function ($basket) {
                    $basket->delete(); // If the normal user have baskets registered, delete all baskets
                });
            }
                
            $this->userManagement->destroy($id);
    
            return redirect()->back()->with('ok', __('User deleted successfully ! We will miss him.'));
        }

        else return redirect()->route('admin')->withError(__('Error while deleting this user. Shit ?'));
    }

    public function createUser()
    {
        return view('admin.user.create');
    }

    public function updateUser(UserUpdateRequest $request, $id)
    {
        $this->setAdmin($request);
        $this->userManagement->update($id, $request->validated());
        return redirect()->route('admin')->withOk(__("The user")." <b>" . $request->input('firstname') . "</b> ".__('has been edited'));
    }

    private function setAdmin($request)
    {
        if(!$request->has('admin'))
        {
            $request->merge(['admin'=>0]);
        }
    }
}

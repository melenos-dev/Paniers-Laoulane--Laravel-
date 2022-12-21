<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Mail;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Management\UserManagement;
use App\Management\ProductManagement;
use App\Management\SupplierManagement;
use App\Management\OrderManagement;

class UsersController extends Controller
{
    protected $userManagement;

    public function __construct (UserManagement $userManagement)
    {
        $this->middleware('auth', ['except'=> ['getInfos', 'store']]);
        $this->userManagement=$userManagement;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductManagement $productManagement, SupplierManagement $supplierManagement, OrderManagement $orderManagement)
    {
        $links='';
        $products = $this->userManagement->falseIfObjectEmpty(\Auth::user()->products()->where('state', '=', 1)->paginate(12));
        $supplier = $supplierManagement->getByUserId(\Auth::user()->id); // utiliser le model et supprimer cette fonction
        $basket_products = $this->userManagement->falseIfObjectEmpty(\Auth::user()->baskets);
        $userOrders = \Auth::user()->orders->where('status', '=', '0');
        $userHistory = \Auth::user()->orders->where('status', '=', '1')->count();
        $merchantOrders = \Auth::user()->merchantOrders()->get()->where('status', '=', '0');

        if($products)
            $links=$products->render();
  
        return view ('user.index', compact('products', 'links', 'supplier', 'basket_products', 'userOrders', 'merchantOrders', 'userHistory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getInfos()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $this->setAdmin($request);
        $user=$this->userManagement->store($request->validated());

        if($user)
        {
            if($request->routeIs('auth.first-login'))
            {
                Mail::send('emails/email_first-log', $request->validated(), function($message) use($user)
                {
                    $message->to($user->email)->subject(__('Welcome !'));
                });

                Mail::send('emails/email_subscription', $request->validated(), function($message)
                {
                    $message->to(config('app.adminMail'))->subject(__('New registration on the website'));
                });

                return view('auth.first-login');
            }
            else
                return redirect()->route('admin')->withOk("L'utilisateur <b>". $user->firstname . "</b> a été créé.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=$this->userManagement->getById($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *²
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userManagement->getById($id);
        if(\Auth::user()->id === $user->id) // Only the authenticated user can update his own account
        {
            $this->setAdmin($request);
            $this->userManagement->update($id, $request->validated());
            return redirect()->route('user.index')->withOk(__("Your information are successfuly been edited."));
        }
        else return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userManagement->getById($id);
        if(\Auth::user()->id === $user->id) // Only the authenticated user can delete his own account
        {
            $this->userManagement->destroy($id);
            return redirect()->back();
        } 
        else return redirect()->to('/');
    }

    private function setAdmin($request)
    {
        if(!$request->has('admin'))
        {
            $request->merge(['admin'=>0]);
        }
    }
}

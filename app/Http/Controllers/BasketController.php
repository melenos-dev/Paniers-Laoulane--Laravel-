<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BasketRequest;
use App\Management\BasketManagement;
use App\Management\ProductManagement;

class BasketController extends Controller
{
	protected $basketManagement;
	protected $nbPerPage = 12;

    public function __construct(BasketManagement $basketManagement, ProductManagement $productManagement)
    {
    	$this->middleware('auth');
    	$this->basketManagement=$basketManagement;
        $this->productManagement=$productManagement;
    }

    public function editQuantity(basketRequest $request, $id)
    {
        $user_id = $request->user()->id;
    	$inputs=array_merge($request->validated(), ['user_id'=>$user_id]);

        if($request->input('quantity') > $request->input('product_quantity'))
            return redirect()->back()->withErrors(['quantity' => __('We don\'t have enough stock to supply the quantity you specified.')]);    
        if($request->input('quantity') >= 1)
        {
            $this->basketManagement->edit($id, $inputs);
            $ok = 'Quantity edited succesfully !';
        }
        else
        {
            $this->basketManagement->destroy($id);
            $ok = 'Quantity set to 0, product removed from basket !';
        }
    	    
        return redirect()->back()->with('ok', __($ok));
    }

    public function add(basketRequest $request)
    {
        $user_id = $request->user()->id;
    	$inputs=array_merge($request->validated(), ['user_id'=>$user_id]);

        if($request->input('quantity') > $request->input('product_quantity'))
            return redirect()->back()->withErrors(['quantity' => __('We don\'t have enough stock to supply the quantity you specified.')]);    

    	$this->basketManagement->save($inputs);   
        return redirect()->back()->withOk(__('Product added succesfully !').' <a href="'.$request->input('previousUrl').'">'.__('Continue my purchases').'</a> '.__('or').' <a href="'.route('user.index').'">'.__('Validate my basket').' ?</a>');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->basketManagement->destroy($id);
    }
    
}

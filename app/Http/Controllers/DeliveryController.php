<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeliveryRequest;
use App\Management\DeliveryManagement;

class DeliveryController extends Controller
{
	protected $deliveryManagement;
    protected $nbLasts = 2;

    public function __construct(DeliveryManagement $deliveryManagement)
    {

    	$this->deliveryManagement=$deliveryManagement;
    }

    public function create(Request $request)
    {
    	return view ('admin.deliveries.add');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deliveryManagement->destroy($id);
        return redirect()->back();
    }
    
}

<?php
namespace App\Http\Controllers;
use App\Management\OrderManagement;

class OrderController extends Controller
{
	protected $orderManagement;
	protected $nbPerPage = 12;

    public function __construct(OrderManagement $orderManagement)
    {
    	$this->middleware('auth');
    	$this->orderManagement=$orderManagement;
    }

    public function add()
    {
        $baskets = \Auth::user()->baskets;
        $user_id = \Auth::user()->id;
        if($baskets->count() == 0)
            return redirect()->route('user.index')->withError(__('Cancelled order. The stocks were updated before your basket was validated, however you can place a new order.'));
        $order = $this->orderManagement->create($user_id, $baskets);
        return redirect()->route('user.index')->withOk(__('Order confirmed !'));
    }

    public function showForMerchant($id)
    {
        $order=$this->orderManagement->getById($id);
        return view('order.merchant.show', compact('order'));
    }

    public function showForUser($id)
    {
        $order=$this->orderManagement->getById($id);
        $userHistory = \Auth::user()->orders->where('status', '=', '1')->count();
        return view('order.user.show', compact('order', 'userHistory'));
    }

    public function changeStatus($id)
    {
        $order=$this->orderManagement->getById($id);
        $order->status = 1;
        $order->save();
        return redirect()->back()->withOk(__('Delivery confirmed !'));
    }

    public function changeAllStatus()
    {
        $merchantOrders = \Auth::user()->merchantOrders()->get();
        foreach($merchantOrders as $merchantOrder)
        {
            $merchantOrder->status = 1;
            $merchantOrder->save();
        }

        return redirect()->route('user.index')->withOk(__('Deliveries confirmed !'));
    }

    public function userHistory()
    {
        $links = '';
        $orders = $this->orderManagement->falseIfObjectEmpty(\Auth::user()->orders()->where('status', '=', '1')->orderBy('created_at', 'desc')->paginate(40));
        if($orders)
            $links=$orders->render();
        return view('order.user.historical', compact('orders', 'links'));
    }

    public function merchantHistory()
    {
        $links = '';
        $orders = $this->orderManagement->falseIfObjectEmpty(\Auth::user()->merchantOrders()->orderBy('created_at', 'desc')->paginate(40));
        if($orders)
            $links=$orders->render();
        return view('order.merchant.historical', compact('orders', 'links'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->orderManagement->destroy($id);
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use App\Management\LoadFileInterface;
use App\Management\SupplierManagement;
use App\Management\ProductManagement;
use App\Management\CustomTextManagement;

class SupplierController extends Controller
{
    protected $supplierManagement;

    public function __construct(SupplierManagement $supplierManagement)
    {
    	$this->middleware('auth', ['except'=> ['index', 'getById']]);
        $this->supplierManagement=$supplierManagement;
    }

    public function index(CustomTextManagement $customTextManagement)
    {
    	$suppliers=$this->supplierManagement->getAll();
        $customText = $customTextManagement->getById(2);
        
    	return view ('who', compact('suppliers', 'customText'));
    }

    public function getById($id)
    {
        $supplier=$this->supplierManagement->getById($id);
        $products = $supplier->user->products->paginate(12);
        $links = $products->render();
        return view('who', compact('supplier', 'products', 'links'));
    }

    public function create()
    {
        return view ('supplier.add');
    }
    
    public function edit($id)
    {
        $supplier=$this->supplierManagement->getById($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, LoadFileInterface $loadfile, $id)
    {
        $supplier = $this->supplierManagement->getById($id);
        $img = $supplier->img;
        if(!empty($request->file('img')))
        {
            if(!$name = $loadfile->save($request->file('img'), config('app.supplierPath')))
                return view('supplier.edit', compact('supplier'))->with('error', 'Problème avec cette image, vérifiez sa taille, elle est probablement trop lourde. Si vous ne comprenez pas le problème et que vous avez déjà rééssayé, contactez l\'administrateur du site via la page contact.');  
            else
            {
                $this->supplierManagement->deleteFile(config('app.supplierPath').$supplier->img);
                $img = $name;
            }
                
        }
        $this->supplierManagement->edit($id, $img, $request->validated());
        return redirect(route('user.index'))->withOk(__("My producer page ").'<b>'.$request->input('supplier_name').'</b>'.__(' has succesfully been edited.'));
    }

    public function store(SupplierRequest $request, LoadFileInterface $loadfile)
    {
    	$inputs=array_merge($request->validated(), ['user_id'=>$request->user()->id]);
        
        if(!empty($request->file('img')))
        {
            if(!$name = $loadfile->save($request->file('img'), config('app.supplierPath')))
            {
                return view('supplier.add')->with('error', 'Problème avec ce fichier, si vous ne comprenez pas le problème et que vous avez déjà rééssayé, contactez l\'administrateur du site via la page contact.');
            }

            else
                $inputs['img'] = $name;
        }
    	$this->supplierManagement->save($inputs);
        return redirect(route('user.index'))->withOk(__('Producer page successfully added !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->supplierManagement->delete(config('app.supplierPath'), $id);
        return redirect(route('user.index'))->withOk(__("My producer page ").__(' has succesfully been deleted.'));
    }
    
}

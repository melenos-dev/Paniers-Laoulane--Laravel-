<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Management\ProductManagement;
use App\Management\ProductCatManagement;
use App\Management\SupplierManagement;
use App\Management\LoadFileInterface;

class ProductController extends Controller
{
	protected $productManagement;
    protected $productCatManagement;
    protected $supplierManagement;
	protected $nbPerPage = 12;

    public function __construct(ProductManagement $productManagement, productCatManagement $productCatManagement, SupplierManagement $supplierManagement)
    {
    	$this->middleware('auth', ['except'=> ['index', 'search']]);
    	$this->productManagement=$productManagement;
        $this->productCatManagement=$productCatManagement;
        $this->supplierManagement=$supplierManagement;
    }

    public function index($id)
    {
    	$product = $this->productManagement->getById($id);
        if($product->state == 0)
            return view('errors.404');
        $supplier = $this->supplierManagement->getByUserId($product->user_id);
    	$quantity = $this->productManagement->getStock($product->getQuantity());
        $categories=$this->productCatManagement;

        $ariane = $this->productCatManagement->getAriane($product->productCat);
    	return view ('product.index', compact('product', 'ariane', 'quantity', 'supplier', 'categories'));
    }

    public function create()
    {
        if(!$this->supplierManagement->getByUserId(\Auth::user()->id))
            return redirect(route('supplier.create'))->withError(__('You have to create your producer page so you can add a product'));
        $catParents = $this->productCatManagement->getAllParents();
        $productCatManagement = $this->productCatManagement;
        return view ('product.add', compact('catParents', 'productCatManagement'));
    }

    public function search(Request $request)
    {
        $links='';
        $products = $this->productManagement->falseIfObjectEmpty($this->productManagement->getByQuery($request->input('query')));
        if($products)
            $links=$products->render();
        return view ('product.search', compact('products', 'links'));
    }
    
    public function edit($id)
    {
        $catParents = $this->productCatManagement->getAllParents();
        $productCatManagement = $this->productCatManagement;
        $product=$this->productManagement->getById($id);
        return view('product.edit', compact('product', 'productCatManagement', 'catParents'));
    }

    public function update(ProductUpdateRequest $request, LoadFileInterface $loadfile, $id)
    {
        $product = $this->productManagement->getById($id);
        if(\Auth::user()->id != $product->user_id) // If the user is not the owner of the product
            return redirect()->to('/');
        $productCatManagement = $this->productCatManagement;
        $qLeft = $product->getQuantity();
        if(($request->product_quantity - $product->product_quantity) + $qLeft < 0) // If the new quantity of this product is lower than the quantities recorded in the baskets, simply delete all the baskets with this product ID
            $product->baskets->each(function ($basket) {
                $basket->delete();
            });
            
        $img = $product->img;
        if(!empty($request->file('img')))
        {
            if(!$name = $loadfile->save($request->file('img'), config('app.productPath')))
            {
                $catParents = $productCatManagement->getAllParents();
                return view('product.edit', compact('product', 'catParents', 'productCatManagement'))->with('error', 'Problème avec cette image, vérifiez sa taille, elle est probablement trop lourde. Si vous ne comprenez pas le problème et que vous avez déjà rééssayé, contactez l\'administrateur du site via la page contact.');  
            }
                
            else
            {
                $this->productManagement->deleteFile(config('app.productPath').$product->img);
                $img = $name;
            }
                
        }
        $this->productManagement->edit($id, $img, $request->validated());
        return redirect(route('user.index'))->withOk(__("The product ").'<b>'.$request->input('product_name').'</b> '.__('has succesfully been edited.'));
    }

    public function store(ProductRequest $request, LoadFileInterface $loadfile)
    {
    	$inputs=array_merge($request->validated(), ['user_id'=>$request->user()->id]);
        $productCatManagement = $this->productCatManagement;
        
        if(!empty($request->file('img')))
        {
            if(!$name = $loadfile->save($request->file('img'), config('app.productPath')))
            {
                $catParents = $this->productCatManagement->getAllParents();
                return view('product.add', compact('catParents', 'productCatManagement'))->with('error', 'Problème avec cette image, vérifiez sa taille, elle est probablement trop lourde. Si vous ne comprenez pas le problème et que vous avez déjà rééssayé, contactez l\'administrateur du site via la page contact.');
            }

            else
                $inputs['img'] = $name;
        }
    	$this->productManagement->save($inputs);
        return redirect(route('user.index'))->withOk(__('Product added succesfully !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productManagement->getById($id);

        if(\Auth::user()->id != $product->user_id) // If the user is not the owner of the product
            return redirect()->to('/');

        $product->baskets->each(function ($basket) {
            $basket->delete(); // If there is this product in a basket, delete this basket
        });

        if($this->productManagement->desactivate($id))
            return redirect(route('user.index'))->withOk(__("The product ").__(' has succesfully been deleted.'));
        else
            return redirect(route('user.index'))->with('error', __("An error occurred while deleting."));
    }
    
}

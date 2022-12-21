<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\productCatRequest;
use App\Management\ProductCatManagement;


class ProductCatController extends Controller
{
    protected $productCatManagement;
    protected $productManagement;
    protected $nbPerPage = 7;

    public function __construct(ProductCatManagement $productCatManagement)
    {
    	$this->middleware('auth', ['except'=> ['index', 'getById']]);
    	$this->middleware('role:2')->only('destroy');

    	$this->productCatManagement=$productCatManagement;
    }

    public function create()
    {
        $productCats=$this->productCatManagement->getPaginate($this->nbPerPage);
        $links = '';

        if($productCats)
            $links=$productCats->render();
            
    	return view ('product.productCat.create', compact('productCats', 'links'));
    }

    public function createChild($id)
    {
        $productCats=$this->productCatManagement->getChildPaginate($this->nbPerPage, $id);

        if($productCats)
            $links=$productCats->render();
        else
            $links = '';

        $parent = $this->productCatManagement->getById($id);

        $ariane = $this->productCatManagement->getAriane($parent, "adminPage");
            
    	return view ('product.productCat.create-child', compact('productCats', 'links', 'parent', 'ariane'));
    }

    public function index()
    {

    }

    public function getById($id)
    {
        $category=$this->productCatManagement->getById($id);
        $query=$this->productCatManagement->allProductsByParent($category)->paginate(12);
        $ariane = $this->productCatManagement->getAriane($category, "catPage");

        return view('product.productCat.get-by-id', compact('category', 'query', 'ariane'));
    }

    public function destroy($id)
    {
        $this->productCatManagement->destroy($id);
        return redirect()->back()->withOk('Catégorie(s) supprimée(s) avec succès ! On range ou les produits maintenant ? x)');;
    }
 
    public function edit($id)
    {
        $category=$this->productCatManagement->getById($id);
        return view('product.productCat.edit', compact('category'));
    }

    public function update(productCatRequest $request, $id)
    {
        $this->productCatManagement->update($id, $request->validated());
        return redirect(route('productCat.create'))->withOk(__("The category ").'<b>'.$request->input('name').'</b>'.__(' has succesfully been edited.'));
    }

    public function store(productCatRequest $request, $parent=0)
    {
    	$this->productCatManagement->store($request, $parent);
    	return redirect()->back()->withOk(__("Category ").'<b>'.$request->input('name').'</b>'.__(' succesfully created !'));
    }
}

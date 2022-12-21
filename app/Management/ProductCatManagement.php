<?php
namespace App\Management;
use App\Models\ProductCat;
use App\Management\ProductManagement;
use Illuminate\Support\Str;

class ProductCatManagement extends ResourceManagement
{
	protected $productCat;
	protected $productManagement;
	protected $path;

	public function __construct (ProductCat $productCat, ProductManagement $productManagement)
	{
		$this->model=$productCat;
		$this->path=config('app.productPath');
		$this->productManagement = $productManagement;
	}

	public function store($request, $parent=0)
	{
		$slug=Str::slug($request->name);

		$slug_ref=new $this->model([
			'name'=>$request->name,
			'slug'=>$slug,
			'parent_id'=>$parent
		]);

		$slug_ref->save();	
	}

	public function getPaginate($n)
	{
		$req = $this->model
		->orderBy('id', 'desc')
		->with('parent')
		->where('parent_id', '=', '0')
		->paginate($n);

		if($req->count() == 0) 
			return false;

		return $req;
	}

	public function getChildPaginate($n, $id)
	{
		$req = $this->model
		->orderBy('id', 'desc')
		->where('parent_id', '=', $id)
		->paginate($n);

		if($req->count() == 0)
			return false;

		return $req;
	}

	public function getById($id)
	{
		return $this->model
			->findOrFail($id);
	}

	public function getAriane($current, $from=null) 
	{
		$arrow = '<i class="fa-solid fa-arrow-right"></i> ';
		if($from == "adminPage" || $from == "catPage")
		{
			$path = 'productCat.create.child';

			if($from == "catPage")
				$path = 'productCat.index';
			$end = $arrow.'<span class="active">'.$current->name.'</span>';
		}
		else
		{
			$path = 'productCat.index';
			$end = $arrow.'<a href="'.route($path, array($current->id, $current->slug)).'">'.$current->name.'</a>';
		}
			
		$html = array();
		
		if($current->parent()->count() == 0) // Have no parent
			array_push($html, $end);

		else // Have parent
		{
			$parents = $current->ancestors;

			foreach($parents as $currentParent)
				array_push($html, $arrow.'<a href="'.route($path, array($currentParent->id, $currentParent->slug)).'">'.$currentParent->name.'</a>');

			array_push($html, $end);
		}

		return $html;
	}

	public function getAllParents()
	{
		return $this->model->where([
    		   ['parent_id', '=', '0']])
			   ->orderBy('created_at', 'asc')
			   ->get();
	}

	public function allProductsByParent($parent)
	{
		$categories = $parent->descendantsAndSelf()->get();
		$stockProducts = collect([]);

		foreach($categories as $category)
		{
			$products = $category->products->where('state', '=', '1');

			$products->each(function($product) use ($stockProducts){
				$stockProducts->push($product);
			});
		}

		return $stockProducts;
	}

	public function destroy($id)
	{
		$current = $this->getById($id);
		if($childs = $current->descendants()->whereDepth(1)->get())
		{
			foreach($childs as $child)
			{
				$this->desactivateProducts($child);
				$this->destroy($child->id);
				$this->model->destroy($child->id);
			}
		}
		$this->desactivateProducts($current);
		$this->model->destroy($id);
	}

	public function desactivateProducts($category)
	{
		if($products = $category->products->where('state', '=', '1'))
			if($products->count() > 0)
				foreach($products as $product)
					$product->update(['state' => '0']);
	}
}
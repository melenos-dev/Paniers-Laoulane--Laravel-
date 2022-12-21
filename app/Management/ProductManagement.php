<?php
namespace App\Management;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductManagement extends ResourceManagement
{
	protected $product;

	public function __construct (Product $product)
	{
		$this->model=$product;
	}

	public function getWithCatPaginate($n = 16)	
	{
		return $this->model->with('productCat')
		->orderBy('products.created_at', 'desc')
		->where('state', '=', 1)
		->Paginate($n); 
	}

	public function getById($id)
	{
		return $this->model
			->with('productCat')
			->findOrFail($id);
	}

	public function getByQuery($query)
	{
		if($query == '')
			return false;
		return $this->model
			->with('productCat')
			->where([
				['product_name', 'like', '%'.$query.'%'],
				['state', '=', '1'],
			])
			->paginate(12);
	}

	public function getStock($quantity)
	{
		if($quantity == 0)
			$quantity = __('Out of stock');
		else
			$quantity = $quantity.' '.__('product(s)');
		return $quantity;
	}

	public function getByIdWithBasketAndUser($id)
	{
		return $this->model
			->with('productCat', 'basket')
			->leftjoin('baskets', function($join){
				$join->where('baskets.user_id', '=', \Auth::user()->id);
	 		})
			->findOrFail($id);
	}

	public function QueryWithUserAndproductCat($n)
	{
		return $this->model->with('user', 'productCat')
		->orderBy('products.created_at', 'desc');
		//->simplePaginate($n);
		/*
		return $this->product->with('user')
		->latest('projects.created_at')
		->paginate($n);
		 */
	}

	public function save($inputs)
	{
		$inputs['slug']=Str::slug($inputs['product_name']);

		$this->store($inputs);	
	}

	public function edit($id, $img, $inputs)
	{
		$inputs['slug']=Str::slug($inputs['product_name']);
		$inputs['img'] = $img;

		$this->update($id, $inputs);	
	}
	
	public function getWithUserAndproductCatsPaginate($n) 
	{
		return $this->QueryWithUserAndproductCats($n)->simplePaginate();
	}

	public function getWithUserAndproductCatforCatPaginate($productCat, $n)
	{
		return $this->QueryWithUserAndproductCat()
		->whereHas('productCat', function($q) use ($productCat)
		{
			$q->where('productCat.slug', $productCat);
		})->paginate($n);
	}

	public function desactivate($product)
	{
		if(\Auth::user()->id != $product->user_id) // If the user is not the owner of the product
			return redirect()->to('/');
		$product->update(['state' => '0']);
		return true;
	}

	public function reallyDestroy($path, $id)
	{
		if(!$product=$this->model->findOrFail($id))
			return false;
		$this->deleteFile($path.$product->img);
		$product->delete();
		return true;
	}
}
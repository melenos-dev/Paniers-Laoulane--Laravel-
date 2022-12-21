<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
	use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

	protected $fillable=['name', 'slug', 'parent_id'];
	protected $table = 'products_cat';

	public function products()
	{
    	return $this->hasMany('App\Models\Product', 'category_id');
	}

	public function children()
	{
		return $this->hasMany('App\Models\ProductCat' , 'parent_id');
	}

    public function getAllParents()
    {
        $parents = collect([]);
        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
}

<?php
namespace App\Management;
use App\Models\Supplier;

class SupplierManagement extends ResourceManagement
{
	protected $supplier;

	public function __construct (Supplier $supplier)
	{
		$this->model=$supplier;
	}	

	public function getByUserId($id)
	{
		$supplier = $this->model->with('user')->where('user_id', '=', $id)->first();
		return $supplier;
	}

	public function getAll()
	{
		$suppliers = $this->model->get();
		return $suppliers;
	}

	public function getById($id)
	{
		return $this->model->with('user')->findOrFail($id);
	}

	public function getWithUser()
	{
		return $this->model->with('user')->get();
	}

	public function save($inputs)
	{
		$this->store($inputs);	
	}

	public function edit($id, $img, $inputs)
	{
		$inputs['img'] = $img;

		$this->update($id, $inputs);	
	}

	public function delete($path, $id)
	{
		$supplier=$this->model->findOrFail($id);
		$this->deleteFile($path.$supplier->img);
		$supplier->delete();
	}
}
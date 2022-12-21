<?php
namespace App\Management;

abstract class ResourceManagement
{
	protected $model;

	public function getPaginate ($n)
	{
		return $this->model->paginate($n);
	}

	public function fill($request)
	{
		return $this->model->fill($request);
	}

	public function toArray()
	{
		return $this->model->toArray();
	}

	public function falseIfObjectEmpty($object)
	{
		if(blank($object))
			return false;
		return $object;
	}

	public function store (Array $inputs)
	{
		return $this->model->create($inputs);
	}
	
	public function getById ($id)
	{
		return $this->model->findOrFail($id);
	}
		
	public function update ($id, Array $inputs)
	{
		return $this->getById($id)->update($inputs);
	}
		
	public function destroy ($id)
	{
		return $this->getById($id)->delete();
	}

	public function deleteFile($path)
	{
		if (file_exists($path)) {
			@unlink($path);
		}
	}
}
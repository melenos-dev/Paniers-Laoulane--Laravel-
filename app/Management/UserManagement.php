<?php
namespace App\Management;
use App\Models\User;

class UserManagement extends ResourceManagement
{
	protected $user;

	public function __construct (User $user)
	{
		$this->model=$user;
	}

	public function getPaginate($n)
	{
		return $this->model->where('admin', '!=', '2')->paginate($n);
	}

	/*
	public function storeNew(Array $inputs)
	{
		$user = new $this->model;
		$user->fill($inputs);
		$user->password=bcrypt($inputs['password']);
		$user->save($user->toArray());
		return $user;
	}

	public function store(Array $inputs)
	{
		$user = new $this->user;
		$user->password=bcrypt($inputs['password']);
		$this->save($user, $inputs);
		return $user;
	}

	public function getById($id)
	{
		return $this->user->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
	*/
}
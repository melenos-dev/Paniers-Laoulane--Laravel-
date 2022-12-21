<?php
namespace App\Management;
use App\Models\CustomText;

class CustomTextManagement extends ResourceManagement
{
	protected $customText;

	public function __construct (CustomText $customText)
	{
		$this->model=$customText;
	}

	public function getAll()
	{
		return $this->model->orderBy('custom_texts.created_at', 'desc')->get();
	}

	public function getById($id)
	{
		return $this->model
			->findOrFail($id);
	}
}
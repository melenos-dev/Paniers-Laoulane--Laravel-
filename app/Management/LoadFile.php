<?php
namespace App\Management;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LoadFile implements LoadFileInterface{

	public function save($image, $path){

		if($image->isValid())
		{
			$extension=$image->extension();
			do {
				$name=Str::random(10) . '.' . $extension;
			} while(file_exists($path.$name));
			$img = Image::make($image->getRealPath());
			if($img->resize(564, 600, function ($constraint) {
				$constraint->aspectRatio();
			})->save($path.$name))
				return $name;
		}
		return false;
	}
}
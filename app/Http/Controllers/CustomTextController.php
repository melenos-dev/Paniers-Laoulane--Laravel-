<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\CustomTextManagement;
use App\Http\Requests\CustomTextUpdateRequest;

class CustomTextController extends Controller
{
    protected $customTextManagement;

    public function __construct(CustomTextManagement $customTextManagement)
    {
    	$this->middleware('auth', ['except'=> ['show']]);
        $this->customTextManagement=$customTextManagement;
    }

    public function index()
    {
        $customTexts = $this->customTextManagement->getAll();
        return view('admin.customText.index', compact('customTexts'));
    }

    public function show($id)
    {
    	$customText = $this->customTextManagement->findOrFail($id);
        if(app()->getLocale() == 'fr')
    	    return $customText->text;
        else
            return $customText->translation;
    }

    public function edit($id)
    {
        $customText=$this->customTextManagement->getById($id);
        return view('admin.customText.edit', compact('customText'));
    }

    public function update(CustomTextUpdateRequest $request, $id)
    {
        $this->customTextManagement->update($id, $request->validated());
        return redirect()->route('admin.customText.index')->withOk(__('Text edited succesfully !'));
    }
}

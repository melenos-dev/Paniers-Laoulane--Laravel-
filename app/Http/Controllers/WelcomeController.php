<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\ProductManagement;
use App\Management\SupplierManagement;
use App\Management\CustomTextManagement;

class WelcomeController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(ProductManagement $productManagement, SupplierManagement $supplierManagement, CustomTextManagement $customTextManagement)
    {
        $products = $productManagement->getWithCatPaginate();
        $suppliers = $supplierManagement->getWithUser();
        $customText = $customTextManagement->getById(1);
        return view ('welcome', compact('products', 'suppliers', 'customText'));
    }
}
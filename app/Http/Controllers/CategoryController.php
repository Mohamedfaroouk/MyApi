<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ApiTrait;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ApiTrait;
    //
    public function __construct() {
        $this->middleware(['authMiddelware:user-api',]);
    }
    /////////////////////////

 public function getCategories()
 {
    $data= Categorie::get();
    return $this->returndata("data",$data);
 }
//////////////////////////////////////////////

public function getProductByCategories(Request $request)
 {

    $data= Product::where("category","LIKE","%".$request->category."%" )-> get();
if($data->first()){
    return $this->returndata("data",$data);}
    else{

        return  $this -> returnError('','Product not found ');

    }
 }

}

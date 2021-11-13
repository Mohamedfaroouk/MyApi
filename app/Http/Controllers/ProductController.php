<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiTrait;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ApiTrait;
    //
    public function __construct() {
        $this->middleware(['authMiddelware:user-api',]);
    }
    /////////////////////////

    public function getProducts()
    {
        $data =  Product::get();

        return $this->returndata("data",$data);
    }

    /////////////////////////

    public function getProdctById(Request $request)
    {
        $product =Product::find($request->id);

        if($product){
         return   $this->returndata("data",$product);

        }
        else{
            return  $this -> returnError('','Product not found ');

        }
    }

///////////////////////////////////

    public function Search(Request $request)
    {
        $product =Product ::where('name', 'LIKE', "%".$request->txt."%")->get();
        if($product->first()){
    return   $this->returndata("data",$product);}
    else{
      return  $this -> returnError('','Product not found ');

    }
    }

///////////////////////////////////

    public function addtoCart(Request $request)
    {

        $product =Product::find($request->id);
        if($product){
    $usercart = Auth::user()->cart;
    $userid =Auth::user()->id;
    $usercart[$request->id] = $product;
   // Product::find($userid)->update(["cart"=> [$usercart]]);
    DB::update('update users set cart = ? where id = ?',[json_encode($usercart),$userid]);
    return $this->returndata("data",$usercart) ;
        }
        else{

      return  $this -> returnError('','Product not found ');

        }

    }

///////////////////////////////////////////

    public function clearCart()
    {
        try{
    $userid =Auth::user()->id;
    DB::update('update users set cart = ? where id = ?',[json_encode([ ]),$userid]);
    return $this->returnSuccessMessage("Cart has been cleard");
}
    catch(\Exception $ex){
        $this -> returnError('','some thing went wrong');
    }

    }

//////////////////////////////////////////////

public function addtoFavourite(Request $request)
    {
        $product =Product::find($request->id);
        if($product){
    $userfavourite = Auth::user()->favourite;
    $userid =Auth::user()->id;
    $userfavourite[$request->id] = $product;
   // Product::find($userid)->update(["cart"=> [$usercart]]);
    DB::update('update users set favourite = ? where id = ?',[json_encode($userfavourite),$userid]);
    return $this->returndata("data",$userfavourite);
    }
    else{
        return  $this -> returnError('','Product not found ');

    }
    }

///////////////////////////////////////////

    public function clearFavourite()
    {
    $userid =Auth::user()->id;
    DB::update('update users set favourite = ? where id = ?',[json_encode([ ]),$userid]);
    return $this->returnSuccessMessage("favourite has been cleard");
    }

//////////////////////////////////////////////

}











/////////////////////
/* $s= DB::select('select * from mytable ');
foreach ($s as $key ) {
 Product::create([
"name"=>$key->name,
"category"=>$key->category,
"priceS"=>$key->price0,
"priceM"=>$key->price1,
"priceL"=>$key->price2,
"description"=>$key->description,
 ]);
} */

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class AdminProductsController extends Controller
{
    //
    //Show all products
    public function index(){
        $products = Product::paginate(6);
        return view("admin.showProducts",['products'=>$products]);
    }

    //Show all the orders
    public function showOrders(){
      $orders = DB::table('orders')->paginate(10);
      return view("admin.ordersPanel",['orders'=>$orders]);

    }

    //Function to show the page with the sales data
    public function showSalesData(){
      $orders = DB::table('orders')->get();
      $totalOrders = count($orders);
      $totalPrices=0;
      for($i=0; $i<$totalOrders; $i++)
      {
        $totalPrices+= $orders[$i]->order_price;
      
      }

      return view("admin.salesData",['totalOrders'=>$totalOrders, 'totalPrices'=>$totalPrices]);
    }

    //function to show the data of the products sold in all the web
    public function showProductData(){
      $orders = DB::table('orders')->get();
      $totalOrders = count($orders);
      $totalPrices=0;
      for($i=0; $i<$totalOrders; $i++)
      {
        $totalPrices+= $orders[$i]->order_price;
      
      }

      $products =  DB::table('order_products')
                 ->select('product_name', DB::raw('count(id) as total'), 'image')
                 ->groupBy('product_name','image')
                ->get();
      $meses;
      for ($i=1; $i<=12 ;$i++){
        $meses[$i-1]= DB::table('orders')
                ->whereMonth('date', $i)
                ->count();

      }

      $usuarios;
      for ($i=1; $i<=12 ;$i++){
        $usuarios[$i-1]= DB::table('users')
                ->whereMonth('created_at', $i)
                ->count();

      }
      


   

      return view("admin.salesData", compact("products", "totalOrders", "totalPrices", "meses", "usuarios"));
    }

    //Function to show the edit product pannel
    public function editProduct($id){
        $product = Product::find($id);
        return view("admin.editProduct",['product'=>$product]);

    }

    //Function to show the edit image product pannel
    public function editProductImage($id){
        $product = Product::find($id);
        return view("admin.editProductImage",['product'=>$product]);

    }

    //Change the image of a product, controlling if the new file is an image
    public function updateImage (Request $request, $id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,jpeg,png|max:4000"])->validate();


        if($request->hasFile("image")){
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists("public/images/".$product->image);

            //deleting the old image
            if($exists){
                Storage::delete('public/images/'.$product->image);
            }

          //Adding the new image
            $extension = $request->file('image')->getClientOriginalExtension(); 
            $request->image->storeAs("public/images/",$product->image);
            $arrayToUpdate = array('image'=>$product->image);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route("adminShowProducts");

        }else{
           $errorupdateImage = "You didn´t select an image";
           return $errorupdateImage;
        }
    }// End of updateImage function

    //update data of a choosen product
    public function updateProduct(Request $request,$id){

       $name =  $request->input('name');
       $description =  $request->input('description');
       $category = $request->input('category');
       $price = $request->input('price');

       //Create the array with the new data for the product
       $updatedDataArray = array("name"=>$name, "description"=> $description,"category"=>$category,"price"=>$price);
       DB::table('products')->where('id',$id)->update($updatedDataArray);
       return redirect()->route("adminShowProducts");
    }

    //Show the pannel to add a new product
    public function createProduct(){
        return view("admin.createProduct");
    }

    //Sending our new product data to our DB
    public function sendCreateProductData(Request $request){
       $name =  $request->input('name');
       $description =  $request->input('description');
       $category = $request->input('category');
       $price = $request->input('price');

       Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,jpeg,png|max:4000"])->validate();
       $extension = $request->file('image')->getClientOriginalExtension();
       //Rename the image file without blanks
       $stringImageReNamed = str_replace(" ","",$request->input('name'));

       $imageName = $stringImageReNamed.".".$extension;//nameofproduct.png
       $encodedImage = File::get($request->image);
       Storage::disk('local')->put('public/images/'.$imageName, $encodedImage);

       $newProductDataArray = array("name"=>$name, "description"=> $description, "image"=> $imageName, "category"=>$category, "price"=>$price);
       $createdProduct = DB::table("products")->insert($newProductDataArray);

       //Proving if the product was created properly
       if($createdProduct){
        return redirect()->route("adminShowProducts");
       }else{
        return "Product was not created properly";
       }

    }

    //Function to delete a product
    public function deleteProduct($id){
      $product = Product::find($id);
      $exists =  Storage::disk("local")->exists("public/images/".$product->image);

      //Delete the image
      if($exists){
          //delete it
          Storage::delete('public/images/'.$product->image);
      }

      //Delete the product from our DB
      Product::destroy($id);
      //Redirect the user to the dashboard again
      return redirect()->route("adminShowProducts");
    }

    //function to eliminate an order from the website
    public function deleteOrder(Request $request, $id){
      $orderToDelete = DB::table('orders')->where("order_id",$id)->delete();

        if($orderToDelete){
          return redirect()->back()->with('orderDeletionAlert', 'The order '.$id. ' was deleted with exit');
        }else{
          return redirect()->back()->with('orderDeletionAlert', 'The order '.$id. ' was NOT deleted');
        }        
    }

    //Function to show the edit order pannel
    public function editOrder($id){
      $order = DB::table('orders')->where("order_id",$id)->get();
      return view("admin.editOrder",['order'=>$order[0]]);

    }

    //Function to change and update the data of an order
    public function updateOrder(Request $request,$id){
      $date =  $request->input('date');
      $user_email =  $request->input('user_email');
      $state = $request->input('state');
      $order_price = $request->input('order_price');

      $arrayToUpdate = array("date"=>$date, "user_email"=> $user_email,"state"=>$state,"order_price"=>$order_price);
      DB::table('orders')->where('order_id',$id)->update($arrayToUpdate);
      return redirect()->route("showOrders");

    }

    //Function to show the view with the content of a specific order
    public function viewOrder($id){
      $products = DB::table('order_products')->where("order_id",$id)->get();
     
      return view("admin.viewOrder",compact("products"));

    }



}

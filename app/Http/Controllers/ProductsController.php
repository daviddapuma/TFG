<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Mail\OrderAsked;
use Illuminate\Support\Facades\Mail;

class ProductsController extends Controller
{
    //index function
    public function index(){
    	$products = Product::paginate(6);
        $recommended_products = DB::table('recommended_products')->get();
    	return view("allproducts",compact("products", "recommended_products"));
    }

    //Function to show products from a chosen category
    //Deportes
    public function sportsProducts(){
        $products = DB::table('products')->where('category', "Deportes")->get();
        return view("sportsProducts",compact("products"));
    }

    //Vinos
    public function winesProducts(){
        $products = DB::table('products')->where('category', "Vinos")->get();
        return view("winesProducts",compact("products"));
    }

    //Colchones
    public function mattressesProducts(){
        $products = DB::table('products')->where('category', "Colchones")->get();
        return view("mattressesProducts",compact("products"));
    }

    //Complementos
    public function complementsProducts(){
        $products = DB::table('products')->where('category', "Complementos")->get();
        return view("complementsProducts",compact("products"));

    }

    //Function to add a product to the cart
    public function addProductToCart(Request $request, $id){
    	//saving session so we dont lost the data added into the cart with laravel
    	$previousCart = $request->session()->get('cart');
        $cart = new Cart($previousCart);

        //Getting the data of the complete product with find
        $product = Product::find($id);
        $cart->addItemToCart($id,$product);
        $request->session()->put('cart', $cart);

        //dump is only used to show the content of our cart, debugging
        //dump($cart);
        return redirect()->route("allProducts");
    }

    //Function to show the content of the cart
    public function showWholeCart(){

            $cart = Session::get('cart');

            //cart is not empty, and we show all his products
            if($cart){
                //dump($cart);
                return view('cartproducts',['cartItems'=> $cart]);
             //cart is empty so we dont show the cart
            }else{
                //echo "empty cart";
                return redirect()->route("allProducts");
            }

    }

    //Function to delete a product from the cart
    public function deleteProductFromTheCart(Request $request, $id){
        //Prove is this id is already on our cart
        $cart = $request->session()->get("cart");

        //Eliminating this item by its id with unset
        if(array_key_exists($id,$cart->items)){
            unset($cart->items[$id]);
        }

        $previousCart = $request->session()->get("cart");
        $updatedCart = new Cart($previousCart);
        //Update our "new" cart after eliminating the product
        $updatedCart->updateCart();

        //We update our session cart, because if not we will still havethe cart without eliminating the choosen product
        $request->session()->put("cart",$updatedCart);

        return redirect()->route('cartProducts');
    }

    //Function to increase quantity of a product from the cart
    public function increaseChosenProduct(Request $request,$id){
        $previousCart = $request->session()->get('cart');
        $cart = new Cart($previousCart);
        $product = Product::find($id);
        $cart->addItemToCart($id,$product);
        $request->session()->put('cart', $cart);
        //dump($cart);
        return redirect()->route("cartProducts");
    }

       //Function to decrease quantity of a product from the cart
       public function decreaseChosenProduct(Request $request,$id){
        $product = Product::find($id);
        $price = (float) str_replace("$","",$product->price);
        $previousCart = $request->session()->get('cart');
        $cart = new Cart($previousCart);

        if($cart->items[$id]['quantity']>1){
                  $product = Product::find($id);
                  $cart->items[$id]['quantity'] = $cart->items[$id]['quantity']-1;
                  $cart->items[$id]['totalSinglePrice'] = $cart->items[$id]['quantity'] * $price;
                  $cart->updateCart();
              
                  $request->session()->put('cart', $cart);        
          }
        return redirect()->route("cartProducts");
    }

    //Function to let the user chek their order and ask for the user data needed
    public function checkOrder(){

        return view('checkorder');
    }

    //Function to create an order with all the data of the order, the user that has made it and the products have been bought on it.
    public function createNewOrder(Request $request){
        //Get the current car
        $cart = Session::get('cart');
        //Getting the user data
        $user_email = $request->input('user_email');
        $user_name = $request->input('user_name');
        $user_surnames = $request->input('user_surnames');
        $user_address = $request->input('user_address');
        $user_postalCode = $request->input('user_postalCode');
        $user_number = $request->input('user_number');

        //cart is not empty
        if($cart) {
        // dump($cart);
            $date = date('Y-m-d H:i:s');
            $arrayNewOrder = array("state"=>"Ordered","date"=>$date,"delivering_date"=>$date,"order_price"=>$cart->totalPrice,
                "user_email"=>$user_email,"user_name"=>$user_name,"user_surnames"=>$user_surnames,"user_address"=>$user_address,
                "user_postalCode"=>$user_postalCode,"user_number"=>$user_number);
            //Insert all the Order created data on orders table
            $orderCreated = DB::table("orders")->insert($arrayNewOrder);
            $orderId = DB::getPdo()->lastInsertId();;

            //Insert in our table order_products, all the products from the order
            foreach ($cart->items as $cart_item){
                $productId = $cart_item['data']['id'];
                $productName = $cart_item['data']['name'];
                $productPrice = (float) str_replace("$","",$cart_item['data']['price']);
                $totalItems = $cart_item['quantity'];
                $productImage = $cart_item['data']['image'];
                $newProductInCurrentOrder = array("product_id"=>$productId,"order_id"=>$orderId,"product_name"=>$productName,"product_price"=>$productPrice,"total_items"=>$totalItems, "image"=>$productImage);
                $orderCreatedItems = DB::table("order_products")->insert($newProductInCurrentOrder);
            }

            //Sending the email to notify the user
            $user = Auth::user();
            $cart = Session::get('cart');

            if($cart != null && $user_email != null){
              Mail::to($user_email)->send(new OrderAsked($cart));
          }

            //delete the old cart when the order has been created, to have an empty cart
            Session::forget("cart");

          //Passing the data to the payment page
            $payment_data = $arrayNewOrder;
            $payment_data['order_id'] = $orderId;
            $request->session()->put('payment_data',$payment_data);
            return redirect()->route("showPaymentData");

        }else{//Cart is empty, so we redirect the user

            return redirect()->route("allProducts");

        }

        
    }


    //Manegement to create an order for the current user
    public function createOrder (){
        //Get the current car
        $cart = Session::get('cart');
        //cart is not empty
        if($cart) {
        // dump($cart);
            $date = date('Y-m-d H:i:s');
            $arrayNewOrder = array("state"=>"Asked","date"=>$date,"delivering_date"=>$date,"order_price"=>$cart->totalPrice);
            $orderCreated = DB::table("orders")->insert($arrayNewOrder);
            $orderId = DB::getPdo()->lastInsertId();;

            //Insert in our table order_products, all the products from the order
            foreach ($cart->items as $cart_item){
                $productId = $cart_item['data']['id'];
                $productName = $cart_item['data']['name'];
                $productPrice = (float) str_replace("$","",$cart_item['data']['price']);
                $totalItems = $cart_item['quantity'];
                $newProductInCurrentOrder = array("product_id"=>$productId,"order_id"=>$orderId,"product_name"=>$productName,"product_price"=>$productPrice,"total_items"=>$totalItems);
                $orderCreatedItems = DB::table("order_products")->insert($newProductInCurrentOrder);
            }

            //delete the old cart when the order has been created, to have an empty cart
            Session::forget("cart");
            Session::flush();
            return redirect()->route("allProducts")->withsuccess("Thanks For Buying in Dapumasold");

        }else{//Cart is empty, so we redirect the user

            return redirect()->route("allProducts");
        }

    }

    //function to search products by key words
    public function searchProducts(Request $request){
        $textToSearch = $request->get('searchText');
        $products = Product::where('name',"Like",$textToSearch."%")->paginate(24);
        $recommended_products = DB::table('recommended_products')->get();
        return view("allproducts",compact("products", "recommended_products"));

    }

    //function to filter products by price
    public function filterProducts(Request $request){
        $amount = (float) $request->get('searchPrice');
        $products = Product::where('price',"<",$amount)->paginate(24);
        $recommended_products = DB::table('recommended_products')->get();
        return view("allproducts",compact("products", "recommended_products"));

    }

}

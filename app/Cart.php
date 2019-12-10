<?php

namespace App;

class Cart
{

    public $items; //[ ['id' => ['quantity' => , 'price' => , 'data' =>],....]
    public $totalQuantity; //number of items for the same product
    public $totalPrice; //Price for the products included in all the cart

     /*
     constructor of the cart.
     */
    public function __construct($previousCart)
    {
        if($previousCart != null){
            $this->items = $previousCart->items;
            $this->totalQuantity = $previousCart->totalQuantity;
            $this->totalPrice = $previousCart->totalPrice;


        }else{ //Cart is empty
            $this->items = [];
            $this->totalQuantity = 0;
            $this->totalPrice = 0;

        }

    }

    //Function to add an item to the cart
    public function addItemToCart($id,$product)
    {
           $price = (float) str_replace("$","",$product->price);

            //knowing if the item already exists in the cart
            if(array_key_exists($id,$this->items))
            {
                $productToAdd = $this->items[$id];
                $productToAdd['quantity']++;
                $productToAdd['totalSinglePrice'] = $productToAdd['quantity'] *  $price;

                //first time this product is going to be added
            }else{

                $productToAdd = ['quantity'=> 1, 'totalSinglePrice'=> $price, 'data'=>$product];
                }


            //Adding the product to our array
            $this->items[$id] = $productToAdd;
            $this->totalQuantity++;
            $this->totalPrice = $this->totalPrice + $price;
    }

    //function to keep the cart info updated
    public function updateCart()
    {
         $totalPrice = 0;
         $totalQuantity = 0;

         //Recalculate both parameters by going over all our array
         foreach($this->items as $item){
             $totalQuantity = $totalQuantity + $item['quantity'];
             $totalPrice = $totalPrice + $item['totalSinglePrice'];
         }

         //Update our variables
         $this->totalQuantity = $totalQuantity;
         $this->totalPrice =  $totalPrice;
    }


}
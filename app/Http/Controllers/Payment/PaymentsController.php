<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Product;
use App\Cart;

class PaymentsController extends Controller {
    public function index(){
        $products = Product::paginate(6);
        return view("allproducts",compact("products"));
    }

    //Function to show the payment data
    public function showPaymentData(){
    	$payment_data = Session::get('payment_data');

        //Order is not paid
        if($payment_data['state'] == 'Ordered'){
            return view('payment.paymentmainpage',['payment_data'=> $payment_data]);
         
        }else{//Order is paid, so redirect to main page
            $this->validate_payment($paypalPaymentID,$paypalPayerID);
            //Function to introduce the order paid in the DB


            //delete info for the payment
            Session::forget("payment_info");
            Session::flush();

            //Return to home apge
            return redirect()->route("allproducts");
           }
}

    //Function to make the process of a payment
    public function processPaymentData($paypalPaymentID,$paypalPayerID){
        //Si exite payment info
        if(!empty($paypalPayerID) && !empty($paypalPaymentID)){
            //Save the payment data
            $this->savePaymentData($paypalPaymentID,$paypalPayerID);
            //Delete to get clean the variable
            Session::forget("payment_data");
            Session::flush();

            //Data introduced so we redirect to home page.
            return redirect()->route("allProducts");
        }else{//Retornamos a la vista principal
            return redirect()->route("allProducts");

        }
    }

    //Function to save the data from a payment
    public function savePaymentData($paypalPaymentID,$paypalPayerID){
        $payment_data = Session::get('payment_data');
        $order_id = $payment_data['order_id'];
        $state = $payment_data['state'];
        $order_price = $payment_data['order_price'];
        $paypal_payer_id = $paypalPayerID;

        if($state == 'Ordered'){
            //Create the row to add in our table
            $arrayNewPayment = array("order_id"=>$order_id,"order_price"=>$order_price, "payer" => $paypal_payer_id);
            $paymentCreated = DB::table("payments")->insert($arrayNewPayment);

            //update the state on that order to mark as paid
            DB::table('orders')->where('order_id', $order_id)->update(['state' => 'Paid']);
      }

    }


	
}

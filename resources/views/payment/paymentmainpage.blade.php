
@extends('layouts.index')


@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Order Payment</li>
            </ol>
        </div>
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p> Delivering Data</p>
                            <div class="form-one">
                                           <div class="total_area">
                                                    <ul>
                                                        <li>Order State<span>{{$payment_data['state']}}</span>
                                                        </li>
                                                        <li>Shipping Cost <span>Free</span></li>
                                                        <li>Total <span>{{$payment_data['order_price']}}</span></li>
                                                    </ul>
                                                    <a class="btn btn-default check_out" id="paypal-button">Pay</a>
                                                </div>
                            </div>
                            <div class="form-two">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section> <!--/#payment-->

@endsection


<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox: 'ASuxl2oG_mSm6KlH8Xmc__YCDS0Ydt_NHCboKigE3iLB0B-g7pJVL5TYroC0e7sdekP2ZSrp4fpUI4CF',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
            total: "{{$payment_data['order_price']}}",
            currency: 'EUR'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
        window.alert('Thank you for buying in dapumasold!');

        window.location = "{{url('cart/orderPaid')}}"+"/"+data.paymentID+'/'+data.payerID;
      });
    }
  }, '#paypal-button');

</script>





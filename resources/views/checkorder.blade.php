
@extends('layouts.index')

@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Check Order</li>
            </ol>
        </div>

         @if(Auth::check())
       
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p> Delivering data</p>
                            <div class="form-one">
                                <form action="{{ route('createNewOrder')}}" method="post" enctype="multipart/form-data">
                                                                
                                                                 {{csrf_field()}}
                                                                
                                    <input type="text" name="user_email" placeholder="Email*" required>
                                    <input type="text" name="user_name" placeholder="Name *" required>
                                    <input type="text" name="user_surnames" placeholder="Surnammes *"  required>
                                    <input type="text" name="user_address" placeholder="Address *" required>
                                    <input type="text" name="user_postalCode" placeholder="Postal Code *" required>
                                    <select>
                                        <option>City</option>
                                        <option>Salamanca</option>
                                        <option>Ávila</option>
                                        <option>Zamora</option>
                                    </select>
                                    <input type="text" name="user_number" placeholder="Phone number *" required>
                                <button class="btn btn-default check_out" type="submit" name="submit" >Acces to payment</button>
                                </form>
                            </div>
                        </div>
                    </div>   
                </div>
            </div> 
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
      @else
        <div class="alert alert-danger" role="alert">
            <strong>Please!</strong> <a href="{{route('login') }}">Log in</a> You need to log in to make an Order
        </div>
      @endif
    </div>
</section><!--/#do_action-->

@endsection





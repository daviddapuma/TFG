@extends('layouts.admin')

@section('body')


<h1>Order {{$products[0]->order_id}} Content</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Product </th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total price</th>
        </tr>
        </thead>
        <tbody>

        @foreach($products as $product)  
        <tr>
            <td><img src="{{Storage::disk('local')->url('images/'.$product->image)}}" alt="" width="100" height="100" style="max-height:200px" ></td>
            <td>{{$product->product_name}}</td>
            <td>{{$product->total_items}}</td>
            <td>{{$product->product_price}}</td>
            <td>{{$product->product_price*$product->total_items}}</td>
        </tr>

        @endforeach
        </tbody>
    </table>

</div>


@endsection


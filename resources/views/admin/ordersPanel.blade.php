@extends('layouts.admin')

@section('body')


<h1>Orders Panel</h1>

@if(session('orderDeletionAlert'))
<div class="alert alert-danger"> {{session('orderDeletionAlert')}} </div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Order_id</th>
            <th>Created At</th>
            <th>Price</th>
            <th>user_email</th>
            <th>Address</th>
            <th>State</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>

        @foreach($orders as $order)  
        <tr>
            <td><a href="{{route('adminViewOrder',['id' => $order->order_id ])}}" class="btn btn-primary">{{$order->order_id}}</a></td>
            <td>{{$order->date}}</td>
            <td>{{$order->order_price}}€</td>
            <td>{{$order->user_email}}</td>
            <td>{{$order->user_address}}</td>
            <td>{{$order->state}}</td>
            <td><a href="{{route('adminEditOrder',['id' => $order->order_id ])}}" class="btn btn-primary">Edit</a></td>
            <td><a href="{{route('adminDeleteOrder',['id' => $order->order_id ])}}"  
                onclick="return confirm('Do you want to delete this order?')"
            class="btn btn-warning">Delete</a></td>
        </tr>

        @endforeach
        </tbody>
    </table>

    {{$orders->links()}}

</div>

@endsection






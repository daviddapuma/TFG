
@extends('layouts.admin')

@section('body')

<div class="table-responsive">
    <form action="{{route('adminUpdateOrder',['order_id' => $order->order_id ])}} " method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" id="date" placeholder="Date" value="{{$order->date}}" required>
        </div>
        <div class="form-group">
            <label for="del_date">User Email</label>
            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="User email" value="{{$order->user_email}}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type=number step="0.01" class="form-control" name="order_price" id="order_price" placeholder="Order price" value="{{$order->order_price}}" required>
        </div>
        <div class="form-group">
            <label for="status">State</label>
            <input type="text" class="form-control" name="state" id="state" placeholder="State" value="{{$order->state}}" required>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
</div>

@endsection
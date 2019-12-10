@extends('layouts.sales')

@section('body')


<h1>Sales Data</h1>
<h2>Total Orders</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Total Orders</th>
            <th>Total Benefits</th>
        </tr>
        </thead>
        <tbody>
        <tr>
           <td>{{$totalOrders}}</td>
            <td>{{$totalPrices}}</td>
        </tr>
        </tbody>
    </table>
</div>

<h2>Products asked</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>En Cuantos pedidos</th>
        </tr>
        </thead>
        <tbody>

        @foreach($products as $product)
        <tr>
           <td><img src="{{asset ('storage')}}/images/{{$product->image}}" alt="" width="100" height="100" style="max-height:200px" ></td>
            <td>{{$product->product_name}}</td>
            <td>{{$product->total}}</td>
        </tr>

        @endforeach
        </tbody>
    </table>


</div>

<div id="GraficoGoogleChart-ejemplo-1" style="width: 800px; height: 600px">
</div>

<div id="donutchart" style="width: 900px; height: 500px;"></div>

@endsection
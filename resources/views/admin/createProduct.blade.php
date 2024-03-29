@extends('layouts.admin')

@section('body')

<div class="table-responsive">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{!! print_r($errors->all()) !!}</li>
        </ul>
    </div>
    @endif


    <h2>New Product Data</h2>
    <form action="{{ route('adminSendCreateProduct')}}" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="description" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class=""  name="image" id="image" required>
        </div>
        <div class="form-group">
            <label for="type">Category</label>
            <input type="text" class="form-control" name="category" id="category" placeholder="category" required>
        </div>
        <div class="form-group">
            <label for="type">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="price" required>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
</div>
@endsection
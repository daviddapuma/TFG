@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p> Name: {!! Auth::user()->name !!}</p>
                    <p> E-mail: {!! Auth::user()->email !!}</p>

                    <a href="{{ route('allProducts')}}" class="btn btn-primary">Home</a>
                    @if($userData->isAdmin())
                    <a href="{{ route('adminShowProducts')}}"  class="btn btn-warning">Admin Dashboard</a>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

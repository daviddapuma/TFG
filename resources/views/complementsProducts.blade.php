
@extends('layouts.index')

@section('center')
<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="{{route('allProducts')}}">Products</a></li>
										<li><a href="{{route('cartProducts')}}">Cart</a></li>
										@if(Auth::check())
										<li><a href="/home"><i class="fa fa-lock"></i> Your Profile</a></li>
										@else
										<li><a href="/login">Login</a></li>
										@endif
                                    </ul>
                                </li>

								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<form action="/search" method="get">
								<input type="text" name="searchText" placeholder="Search"/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>Dapuma</span>-Sold</h1>
									<h2>Online Shop</h2>
									<p>Find products and buy them in a moment. </p>
								</div>
								<div class="col-sm-6">
									<img src="{{asset('images/home/logo.png')}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>Dapuma</span>-Sold</h1>
									<h2>Online Shop</h2>
									<p>Find products and buy them in a moment. </p>
								</div>
								<div class="col-sm-6">
									<img src="{{asset('images/home/logo.png')}}" class="girl img-responsive" alt="" />
								</div>

							</div>


						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<div class="panel panel-default">
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{route('sportsProducts')}}">Deportes</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{route('complementsProducts')}}">Complementos</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{route('mattressesProducts')}}">Colchones</a></h4>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{route('winesProducts')}}">Vinos</a></h4>
								</div>
							</div>
						</div><!--/category-products-->


						<div class="price-range"><!--price-range-->
							<h2>Price Range</h2>
							<div class="well text-center">
							<form action="/filter" method="get">
								<input type="text" name="searchPrice" placeholder="Filter"/>
							</form>
								 <b class="pull-left"> 0 €</b> <b class="pull-right">999 €</b>
							</div>
						</div><!--/price-range-->
					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>

						@foreach ($products as $product)

						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">

											<img src="{{Storage::disk('local')->url('images/'.$product->image)}}" alt="" width="200" height="200" style="max-height:200px"  />
											<h2>{{ $product->price }}€</h2>
											<p>{{ $product->name }}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>{{ $product->price }}€</h2>
												<p>{{ $product->name }}</p>
												<a href="{{route('AddToCartProduct',['id'=>$product->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
								</div>
							</div>
						</div>

						@endforeach
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@endsection
@extends('frontend.includes.front_design')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('frontend.includes.front_sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                    <a href="{{asset('public/adminpanel/uploads/products/small/'.$productDetails->image)}}">
                                        <img class="mainImage" src="{{asset('public/adminpanel/uploads/products/small/'.$productDetails->image)}}" alt="" />
                                    </a>
                                </div>
                                {{--<h3>ZOOM</h3>--}}
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                        @foreach($productAltImages as $altImage)
                                            <a href="{{asset('public/adminpanel/uploads/products/small/'.$altImage->image)}}">
                                                <img class="changeImage" src="{{asset('public/adminpanel/uploads/products/small/'.$altImage->image)}}" alt="" style="width: 80px;">
                                            </a>
                                        @endforeach
                                    </div>


                                </div>

                                <!-- Controls -->
                                <a class="left item-control" href="#similar-product" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right item-control" href="#similar-product" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-sm-7">


                            <form action="{{route('addtocart')}}" method="post" name="addtoCartForm" id="addtoCart">
                                @csrf

                                <input type="hidden" name="product_id" value="{{$productDetails->id}}">

                                <input type="hidden" name="product_name" value="{{$productDetails->product_name}}">

                                <input type="hidden" name="product_code" value="{{$productDetails->product_code}}">

                                <input type="hidden" name="prodcut_color" value="{{$productDetails->prodcut_color}}">

                                <input type="hidden" name="price" value="{{$productDetails->price}}">


                                <div class="product-information"><!--/product-information-->
                                <h2>{{$productDetails->product_name}}</h2>
                                <p>Product Code: {{$productDetails->product_code}}</p>
                                
                                <p>
                                    <select name="size" style="width: 150px;" id="selSize">
                                        <option value="">Select Size</option>
                                        @foreach($productDetails->attributes as $sizes)
                                            <option value="{{$productDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
                                        @endforeach
                                    </select>
                                </p>


                                <span>
									<span id="getPrice">Rs. {{$productDetails->price}}</span>
									<label>Quantity:</label>
									<input type="text" value="1" name="quantity" />
                                    @if($total_stock > 0)
									<button type="submit" class="btn btn-fefault cart cartButton" id="cartButton">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
                                        @endif
								</span>
                                <p><b>Availability:</b>
                                   <span class="availability" id="availability">
                                        @if($total_stock > 0) In Stock @else Out Of Stock @endif
                                   </span>
                                </p>

                            </div><!--/product-information-->
                            </form>
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#care" data-toggle="tab">Care</a></li>
                                <li><a href="#delivery" data-toggle="tab">Delivery</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active in" id="description" >
                                <p>
                                    {{$productDetails->description}}
                                </p>
                            </div>

                            <div class="tab-pane fade" id="care" >
                                <p>
                                    {{$productDetails->care}}
                                </p>
                            </div>

                            <div class="tab-pane fade" id="delivery" >
                                <p>100% More Original products</p>
                                <p>Cash On Delievery</p>
                                <p>30 Days Return Guranatee</p>
                            </div>


                        </div>
                    </div><!--/category-tab-->

                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>

                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php $count = 1; ?>
                                @foreach($relatedProducts->chunk(3) as $chunk)
                                <div  <?php if($count == 1) { ?> class="item active" <?php }  else { ?> class="item" <?php } ?> >

                                    @foreach($chunk as $item)
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="{{asset('public/adminpanel/uploads/products/small/'.$item->image)}}" alt="" />
                                                    <h2>Rs. {{$item->price}}</h2>
                                                    <p>{{$item->product_name}}</p>
                                                    <a href="{{route('single.products', $item->id)}}">
                                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   @endforeach
                                </div>

                                    <?php $count++ ?>
                                    @endforeach

                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div><!--/recommended_items-->

                </div>
            </div>
        </div>
    </section>
    @endsection
@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Products</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add a New Product</h4>
                        @if(Session::has('flash_message_error'))
                            <div class="alert alert-error alert-block">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                            </div>
                        @endif
                        <form class="form" method="post" action="{{route('product.edit', $productDetails->id)}}" id="add_product" name="add_product" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="" class="col-2 col-form-label">Under Category</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" name="category_id" id="category_id">
                                        <?php echo $categories_dropdown ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Product Name</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="product_name" id="product_name" value="{{$productDetails->product_name}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Product Code</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="product_code" id="product_code" value="{{$productDetails->product_code}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Product Color</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="product_color" id="product_color" value="{{$productDetails->prodcut_color}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Price</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="price" id="price" placeholder="Please Enter Product Price" value="{{$productDetails->price}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Product Image</label>
                                <div class="col-10">
                                    <input class="form-control" type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" value="{{$productDetails->image}}">
                                    @if(!empty($productDetails->image))
                                    <img src="{{asset('public/adminpanel/uploads/products/small/'.$productDetails->image)}}" alt="" width="100px;">
                                    <br>
                                    <a href="{{route('delete-productimage', $productDetails->id)}}" class="text-danger">Delete Image</a>
                                  @endif
                                </div>
                            </div>


                            <div class="form-group m-t-40 row">
                                <label for="description" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control col-12">
                                        {{$productDetails->description}}
                                    </textarea>
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="text-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Update Product">
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js?fbclid=IwAR0gve14W2V8EXN6DR0mdbmJ6_pcNkxyRRcUjMPer_eKY7pwwSj8E-WcaKM">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add_product").validate({
                rules: {
                    product_name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    product_code:{
                        required: true
                    },
                    product_color:{
                        required: true
                    },
                    price:{
                        required: true
                    },


                } ,
                messages : {
                    product_name: {
                        required: "<span class='text-danger'> Please Enter Product Name </span>"
                    },
                    description: {
                        required : "<span class='text-danger'> Please Insert Description </span>"
                    },
                    category_id:{
                        required: "<span class='text-danger'> Please Select a Category </span>"
                    },
                    product_code : {
                        required: "<span class='text-danger'> Please Enter Product Code </span>"
                    },
                    product_color : {
                        required: "<span class='text-danger'> Please Enter Product Color </span>"
                    },
                    price : {
                        required: "<span class='text-danger'> Please Enter Price </span>"
                    },


                }
            });
        });

    </script>
@endsection
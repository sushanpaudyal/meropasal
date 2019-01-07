@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Categories</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
                        <h4 class="card-title">Edit Category</h4>
                        <form class="form" method="post" action="{{route('category.edit', $category->id)}}" id="edit_category" name="add_category">
                            @csrf
                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Category Name</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="name" id="name" value="{{$category->name}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-2 col-form-label">Category Level</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" name="parent_id" id="parent_id">
                                        <option value="0">Main Category</option>
                                        @foreach($levels as $level)
                                            <option value="{{$level->id}}" @if($level->id == $category->parent_id)  selected @endif>{{$level->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="description" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control col-12">
                                        {{$category->description}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <div class="col-10">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($category->status == "1") checked @endif>
                                        <label class="custom-control-label" for="status">Status</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="text-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Update Category">
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
            $("#edit_category").validate({
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },

                } ,
                messages : {
                    name: {
                        required: "<span class='text-danger'> Please Enter Category Name </span>"
                    },
                    description: {
                        required : "<span class='text-danger'> Please Insert Description </span>"
                    },


                }
            });
        });

    </script>
@endsection
@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">View All Categories</h4>
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
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Categories Details</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Category Level</th>
                                    <th>Description</th>
                                    <th>Category Slug</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                               <tbody>
                               @foreach($categories as $category)
                                   <tr>
                                       <td>{{$loop->index +1}}</td>
                                       <td>{{$category->name}}</td>
                                       <td>
                                           @if($category->parent_id == 0)
                                               <span class="badge badge-primary">{{ 'Main Category' }}</span>
                                               @endif
                                           @foreach($categories as $c)
                                               @if($c->id == $category->parent_id)
                                                   <span class="badge badge-info">{{ $c->name }}</span>
                                                   @endif
                                               @endforeach
                                       </td>
                                       <td>
                                           {{str_limit($category->description, 40, '[...]')}}
                                       </td>
                                       <td>{{$category->slug}}</td>
                                       <td>
                                           @if($category->status == 1)
                                               <span class="badge badge-success">Active</span>
                                               @else
                                               <span class="badge badge-warning">Inctive</span>
                                           @endif
                                       </td>
                                       <td>
                                           <a href="{{route('category.edit', $category->id)}}" class="btn btn-info">
                                               <i class="fa fa-edit"></i>
                                           </a>
                                           <a rel="{{$category->id}}" rel1="delete-category" href="javascript:" class="btn btn-danger deleteRecord">
                                               <i class="fa fa-trash"></i>
                                           </a>
                                       </td>
                                   </tr>
                                   @endforeach
                               </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>

    @endsection


@section('style')
    <link href="{{asset('public/adminpanel/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    @endsection


@section('script')
    <script src="{{asset('public/adminpanel/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('public/adminpanel/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
    </script>
    <script>
        $(document).ready(function () {
            $(".deleteRecord").click(function(){
                var id = $(this).attr('rel');
                var deleteFunction = $(this).attr('rel1');
                swal({
                        title: "Are You Sure",
                        text: "You will not be able to recover this record again",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Delete it!"
                    },
                    function(){
                        window.location.href="/meropasal/admin/"+deleteFunction+"/"+id;
                    }
                );
            });
        });
    </script>

    <script>
        @if(Session::has('success'))
            toastr.success('{{Session::get('success')}}')
            @endif

            @if(Session::has('info'))
            toastr.info('{{Session::get('info')}}')
        @endif

        @if(Session::has('danger'))
        toastr.error('{{Session::get('danger')}}')
        @endif
    </script>


    @endsection
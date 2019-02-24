@extends('frontend.includes.front_design')

@section('content')
    <section id="form" style="margin-top: 0px;"><!--form-->
        <div class="container">
            <div class="row">
                @if(Session::has('flash_message_error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                @endif
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Login to your account</h2>

                        <form action="{{route('user.login')}}" method="post" id="loginForm" name="loginForm">
                            @csrf
                            <input type="email" placeholder="Email Address" name="email" id="email"/>
                            <input type="password" placeholder="Password"  name="password" id="password"/>

                            <button type="submit" class="btn btn-default">Login</button>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Account Details</h2>
                        <form action="{{url('/account')}}" id="accountForm" name="accountForm" method="post">
                           @csrf
                           <input type="text" name="name" id="name" placeholder="Name"  value="{{$userDetails->name}}"/>

                           <input type="text" name="address" id="address" placeholder="Address " value="{{$userDetails->address}}"/>

                           <input type="text" name="city" id="city" placeholder="City" value="{{$userDetails->city}}"/>

                           <input type="text" name="state" id="state" placeholder="State" value="{{$userDetails->state}}"/>

                           <select name="country" id="country">
                               <option value="">Select Country</option>
                               @foreach($countries as $country)
                                   <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif>{{$country->country_name}}</option>
                                   @endforeach
                           </select>

                           <input style="margin-top: 10px;" type="text" name="pincode" id="pincode" placeholder="Pin Code" value="{{$userDetails->pincode}}"/>

                           <input type="text" name="mobile" id="mobile" placeholder="Mobile" value="{{$userDetails->mobile}}"/>

                           <button type="submit" class="btn btn-default">Update</button>

                       </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
    @endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js?fbclid=IwAR0gve14W2V8EXN6DR0mdbmJ6_pcNkxyRRcUjMPer_eKY7pwwSj8E-WcaKM">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#registerForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email:{
                        required: true,
                        email: true
                    },
                    password:{
                        required: true,
                        minLength: 6
                    }


                } ,
                messages : {
                    name: {
                        required: "<span class='text-danger'> Please Enter Name </span>"
                    },
                    email: {
                        required: "<span class='text-danger'> Please Enter Email </span>",
                        email: "<span class='text-danger'> Please Enter Valid Email </span>"
                    },
                    password:{
                        required: "<span class='text-danger'> Please Enter Password </span>",
                        minLength: "<span class='text-danger'> Password must be more than 6 characters </span>"
                    }



                }
            });





            $("#loginForm").validate({
                rules: {

                    email:{
                        required: true,
                        email: true
                    },
                    password:{
                        required: true,
                        minLength: 6
                    }


                } ,
                messages : {

                    email: {
                        required: "<span class='text-danger'> Please Enter Email </span>",
                        email: "<span class='text-danger'> Please Enter Valid Email </span>"
                    },
                    password:{
                        required: "<span class='text-danger'> Please Enter Password </span>",
                        minLength: "<span class='text-danger'> Password must be more than 6 characters </span>"
                    }



                }
            });
        });

    </script>

    <script src="{{asset('public/frontpanel/js/jquery.passtrength.js')}}"></script>

    <script>
         $("#mypassword").passtrength({
             minChars: 4,
             passwordToggle: true,
             tooltip: true,
             eyeImg: "http://localhost:8888/meropasal/public/frontpanel/images/eye.svg"
         });

    </script>
@endsection

@extends('frontend.includes.front_design')

@section('content')
    <section id="form" style="margin-top: 0px;"><!--form-->
        <div class="container">
            <div class="row">
                @if(Session::has('flash_message_success'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('flash_message_success') !!}</strong>
                    </div>
                @endif
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Update Your Password</h2>

                        <form action="{{url('/update-user-pwd')}}" method="post" id="passwordForm" name="passwordForm">
                            @csrf
                            <input type="password" placeholder="Current Password" name="current_pwd" id="current_pwd"/>
                            <span id="chkPwd"></span>
                            <input type="password" placeholder="New Password"  name="new_pwd" id="new_pwd"/>
                            <input type="password" placeholder="Confirm Password"  name="confirm_pwd" id="confirm_pwd"/>


                            <button type="submit" class="btn btn-default">Update Password</button>
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


    <script src="{{asset('public/frontpanel/js/jquery.passtrength.js')}}"></script>

    <script>
         $("#mypassword").passtrength({
             minChars: 4,
             passwordToggle: true,
             tooltip: true,
             eyeImg: "http://localhost:8888/meropasal/public/frontpanel/images/eye.svg"
         });

    </script>




    <script>
        $("#current_pwd").keyup(function(){
              var current_pwd = $(this).val();
              // alert(current_pwd);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: 'check-user-pwd',
                data: {current_pwd:current_pwd},
                success: function (resp){
                    // alert(resp);
                    if(resp=="false"){
                        $("#chkPwd").html("<font color='red'> Current Password Does Not Match </font>")
                    } else if(resp == "true"){
                        $("#chkPwd").html("<font color='green'> Current Password Matched </font>")
                    }
                }, error: function(){
                    alert("Error");
                }
            });
        });
    </script>


    <script>
        $("#passwordForm").validate({ 
            rules:{ 
                current_pwd:{ 
                    required: true, 
                    minlength:4, 
                    maxlength:20         }, 
                new_pwd:{ 
                    required: true, 
                    minlength:6, 
                    maxlength:20         }, 
                confirm_pwd:{ 
                    required:true, 
                    minlength:6, 
                    maxlength:20, 
                    equalTo:"#new_pwd" 
                }     }, 
            errorClass: "help-inline", 
            errorElement: "span", 
            highlight:function(element, errorClass, validClass) { 
                $(element).parents('.control-group').addClass('error'); 
                },     unhighlight: function(element, errorClass, validClass) { 
                $(element).parents('.control-group').removeClass('error'); 
                $(element).parents('.control-group').addClass('success');     } });
    </script>
@endsection

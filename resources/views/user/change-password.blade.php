@extends( 'layouts.app' )

@section('title', 'Change Account Password')

@section('style')
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');"  class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>Change Account Password</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">Page</a></li>
            <li><a href="javascript:void(0);">Change Account Password</a></li>
        </ul>
    </div>
</div>

<div class="section-block">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-12">
                <div class="section-heading">
                    <h6 class="semi-bold">Change Account Password</h6>
                </div>
                <form id="pass-form" class="primary-form-2 mt-15">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <input type="password" name="curpass" placeholder="Current Password*" required>
                        </div>
                        <div class="col-sm-6 col-12">
                            <input type="password" name="newpass" id="pass1" placeholder="New Password*" required>
                        </div>
                        <div class="col-sm-6 col-12">
                            <input type="password" name="newpass2" id="pass2" onkeyup="checkPass(); return false;" placeholder="Confirm New Password*" required>
                            <span id="confirmMessage"></span>
                        </div>
                    </div>
                    <div class="row mt-15">
                        <div class="text-right">
                            <input type="hidden" name="user_id" value="{{$user->id}}" required>
                            <button type="submit" class="button-md button-primary">Change Password</button>
                        </div>
                    </div>
                </form>
                </div>
           @include('includes.user-side')
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('#pass-form').submit(function(e){
     e.preventDefault();
     //$('#quote').modal('hide');
     open_loader('#page');

     var form = $("#pass-form")[0];
     var _data = new FormData(form);
     $.ajax({
         url: '{{url("user/change-password")}}',
         data: _data,
         enctype: 'multipart/form-data',
         processData: false,
         contentType:false,
         type: 'POST',
         success: function(data){
             if(data.status == "success"){
                 toastr.success(data.message, data.status);
                 window.setTimeout(function(){location.reload();},2000);
                 close_loader('#page');
                 } else{
                     toastr.error(data.message, data.status);
                     close_loader('#page');
                 }
         },
         error: function(result){
             toastr.error('Check Your Network Connection !!!','Network Error');
             close_loader('#page');
         }
     });
     return false;
 });


 function checkPass(){
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
if(pass1.value == pass2.value){
    //The passwords match.
    //Set the color to the good color and inform
    //the user that they have entered the correct password
    pass2.style.backgroundColor = goodColor;
    message.style.color = goodColor;
    message.innerHTML = "Passwords Match!"
}else{
    //The passwords do not match.
    //Set the color to the bad color and
    //notify the user.
    pass2.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = "Passwords Do Not Match!"
}
}

</script>
@endsection

@extends( 'layouts.app' )

@section('title', 'Account Update')

@section('style')
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');"  class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>Account Update</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">Page</a></li>
            <li><a href="javascript:void(0);">Account Update</a></li>
        </ul>
    </div>
</div>

<div class="section-block">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-12">
                <div class="section-heading">
                    <h6 class="semi-bold">Update Account Information</h6>
                </div>
                <form id="update-form" class="primary-form-2 mt-15">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <label>First Name</label>
                            <input type="text" name="fname" value="{{$user->fname}}" required>
                        </div>
                        <div class="col-sm-6 col-12">
                            <label>Last Name</label>
                            <input type="text" name="lname" value="{{$user->lname}}" required>
                        </div>
                        <div class="col-sm-6 col-12">
                            <label>Email Address</label>
                            <input type="email" value="{{$user->email}}" readonly>
                        </div>
                        <div class="col-sm-6 col-12">
                            <label>Phone Number</label>
                            <input type="tel" name="tel" value="{{$user->tel}}" required>
                        </div>
                        <div class="col-sm-12 col-12">
                            <label>Contact Address</label>
                            <input type="text" name="address" value="{{$user->address}}" required>
                        </div>
                        <div class="col-sm-8 col-12">
                            <label>Profile Image</label>
                            <input type="file" id="imgInp" name="image" accept="image/*">
                        </div>
                        <div class="col-sm-4 col-12">
                            <img id="blah" src="{{asset('images/users/'.$user->avatar)}}" style="max-width: 100px; max-height: 100px"/>
                        </div>
                        </div>
                    <div class="row mt-15">
                        <div class="text-right">
                            <input type="hidden" name="user_id" value="{{$user->id}}" required>
                            <button type="submit" class="button-md button-primary">Update Account</button>
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
    function readURL(input) {

        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        }
        }

        $("#imgInp").change(function() {
        readURL(this);
    });

    $('#update-form').submit(function(e){
     e.preventDefault();
     //$('#quote').modal('hide');
     open_loader('#page');

     var form = $("#update-form")[0];
     var _data = new FormData(form);
     $.ajax({
         url: '{{url("user/account-update")}}',
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
</script>
@endsection

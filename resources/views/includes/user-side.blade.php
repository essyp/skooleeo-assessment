<div class="col-md-3 col-sm-12 col-12">
    @if(!empty($user->image))
    <img src="{{asset('images/users/'.$user->image)}}" style="max-height: 70px; max-width: 70px; border-radius: 50px; float: right">
    @else
    <img src="{{asset('images/avatar.png')}}" style="max-height: 70px; max-width: 70px; border-radius: 50px; float: right">
    @endif
    <div class="blog-post-right">
        <h4 class="blog-widget-title">{{$user->fname}} {{$user->lname}}</h4><br>
        <p>ID: <strong>{{$user->ref_id}}</strong></p>
        <div class="blog-post-categories mt-20">
            <ul>
                 <li><a href="{{url('user/account')}}">Account<span></span></a></li>
                 <li><a href="{{url('user/blog')}}">Blog<span></span></a></li>
                 <li><a href="{{url('user/change-password')}}">Change Password<span></span></a></li>
                 <li><a href="{{url('user/account-update')}}">Update Account<span></span></a></li>
                 <li><a href="{{url('logout')}}">Logout<span></span></a></li>
            </ul>
        </div>

    </div>
</div>
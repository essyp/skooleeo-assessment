@extends( 'layouts.app' )

@section('title', $blog->title)

@section('style')
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');" class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>{{$blog->title}}</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">{{$blog->title}}</a></li>
        </ul>
    </div>
</div>

<div class="section-block">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-12">
                <div class="blog-list">
                    <img src="{{asset('images/blog/'.$blog->image)}}" alt="img">
                    <h4><a href="javascript:void(0);">{{$blog->title}}</a></h4>
                    <ul class="blog-list-info">
                        <li><i class="ti-user"></i><span>{{$blog->user->fname}} {{$blog->user->lname}}</span></li>
                        <li><i class="ti-calendar"></i><span>{{date("d F, Y",strtotime($blog->created_at))}}</span></li>
                        <li><i class="ti-pin-alt"></i><span><a href="{{url('blog/category/'.$blog->cat->slug)}}">{{$blog->cat->name}}</a></span></li>
                        <li><i class="ti-eye"></i><span>{{$blog->views}}</span></li>
                    </ul>
                    <p>{!! $blog->description !!}</p>
                    <h4 class="blog-widget-title">Share Blog</h4>
                    <div class="blog-post-follow mt-20">
                        <ul>
                            <li class="social-link"><a href="http://www.facebook.com/sharer.php?u={{url('blog/'.$blog->slug)}}" rel="nofollow" onclick="window.open(this.href,this.title,'width=600,height=600,top=200px,left=200px');  return false;" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="social-link"><a href="http://twitter.com/share?text={{$blog->title}}&url={{url('blog/'.$blog->slug)}}" rel="nofollow" onclick="window.open(this.href,this.title,'width=600,height=600,top=200px,left=200px');  return false;" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li class="social-link"><a href="http://www.linkedin.com/shareArticle?mini=true&url={{url('blog/'.$blog->slug)}}" rel="nofollow" onclick="window.open(this.href,this.title,'width=600,height=600,top=200px,left=200px');  return false;" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li class="social-link"><a href="https://plus.google.com/share?url={{url('blog/'.$blog->slug)}}" rel="nofollow" onclick="window.open(this.href,this.title,'width=600,height=600,top=200px,left=200px');  return false;" target="_blank"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
           @include('includes/blog-side')
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.post('{{url("update-views")}}',
            {
                _token:'{{csrf_token()}}',
                blog_id: '{{$blog->id}}'
            },
        function(data){});
    });
</script>

@endsection

@extends( 'layouts.app' )

@section('title','Blog')

@section('style')
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');" class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>Blog</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">Pages</a></li>
            <li><a href="javascript:void(0);">Blog</a></li>
        </ul>
    </div>
</div>

<div class="section-block">
        <div class="container">
            <div class="row">
            <div class="col-md-9 col-sm-12 col-12">
            <div class="row mt-40">
                @foreach ($data as $bl)
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="blog-grid">
                        <img src="{{asset('images/blog/'.$bl->image)}}" style="height: 250px; max-width: 500px">
                        <div class="blog-team-box">
                            <h6>{{date("M d, Y",strtotime($bl->created_at))}}</h6>
                        </div>
                        <h4><a href="{{url('blog/'.$bl->slug)}}">{{$bl->title}}</a></h4>
                        <p>{!!substr($bl->description,0,150)!!}...   <a href="{{url('blog/'.$bl->slug)}}" class="button-simple-primary mt-20">Read More <i class="fas fa-arrow-right"></i></a></p>
                    </div>
                </div>
                @endforeach

            </div>
                  {{$data->links('front.pagination')}}
            </div>
           @include('includes/blog-side')
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection

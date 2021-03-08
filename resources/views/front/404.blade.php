@extends( 'layouts.app' )

@section('title','404 Error Page')

@section('style')
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');" class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>404</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">404</a></li>
        </ul>
    </div>
</div>

<div class="error-section-2 full-height text-center">
        <div class="container">
            <h1>404</h1>
            <h2>Oops, This Page Could Not Be Found!</h2>
            <h3>We couldn't find the page you were looking for.</h3>
            <a href="{{url('/')}}" class="button-md button-primary-bordered mt-30">Back Home</a>
        </div>
    </div>
@endsection

@section('script')
@endsection

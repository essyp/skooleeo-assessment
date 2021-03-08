<!DOCTYPE html><html lang="zxx">
<head>
    <title>Skooleeo Assessment - @yield('title')</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/fontawesome-all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/icomoon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/rev-settings.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/waitMe.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/styles-2.css')}}" id="main_styles">
    @yield('style')
</head>
<body id="page">
<div id="preloader">
        <div class="lds-ellipsis">
            <div></div><div></div><div></div><div></div></div></div>

    <header>
        <nav id="navigation4" class="container navigation">
            <div class="nav-header">
                <a class="nav-brand" href="{{url('/')}}">
                    <img src="{{asset('images/logo.png')}}" style="max-height: 70px; max-width: 130px" class="main-logo" id="main_logo" alt="logo">
                </a>
                <div class="nav-toggle"></div>

            </div>
            <div class="nav-menus-wrapper">
            <ul class="nav-menu align-to-right">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/')}}">Blog</a></li>
                    @if(!empty(Auth::guard('user')->user()))
                    <li style="padding-top: 17px;"><button style="background-color: #202CA6;" onclick="location.href='{{url('user/account')}}';" class="btn btn-success">Account</button></li>
                    @else
                    <li style="padding-top: 17px;"><button style="background-color: #202CA6;" onclick="location.href='{{url('login')}}';" class="btn btn-success">Login | Register</button></li>
                    @endif
                </ul>
            </div>
        </nav>
    </header>


    @yield('content')




<footer>
        <div class="footer-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" style="max-height: 100px; max-width: 100px" id="footer_logo" alt="logo"></a>
                        <p class="mt-20">Skooleeo assessment for software developer role</p>
                        <ul class="social-links-footer">
                            <li><a href="" target="_blank"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="row mt-25">
                            <div class="col-md-6 col-sm-6"></div>
                            <div class="col-md-6 col-sm-6"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12"></div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <h2>Subscribe</h2>
                        <form id="news-form" class="footer-subscribe-form mt-25">
                            {{ csrf_field() }}
                            <div class="d-table full-width">
                                <div class="d-table-cell">
                                    <input type="text" name="email" placeholder="Your Email address">
                                </div>
                                <div class="d-table-cell">
                                    <button type="submit"><i class="fas fa-envelope"></i></button>
                                </div>
                            </div>
                        </form>
                        <p class="mt-10">Get latest updates and offers.</p>
                    </div>
                </div>
                <div class="footer-1-bar">
                    <p>Skooleeo © <?php echo date("Y"); ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <a href="#" class="scroll-to-top"><i class="fas fa-chevron-up"></i></a>

    <script src="{{asset('home/js/jquery.min.js')}}"></script>
    <script src="{{asset('home/js/plugins.js')}}"></script>
    <script src="{{asset('home/js/navigation.js')}}"></script>
    <script src="{{asset('home/js/navigation.fixed.js')}}"></script>
    <script src="{{asset('home/js/map.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/jquery.themepunch.revolution.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.actions.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.carousel.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.kenburn.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.layeranimation.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.migration.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.parallax.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.navigation.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.slideanims.min.js')}}"></script>
    <script src="{{asset('home/js/rev-slider/revolution.extension.video.min.js')}}"></script>
    <script src="{{asset('home/js/main.js')}}"></script>
    <script src="{{asset('home/js/toastr.min.js')}}"></script>
    <script src="{{asset('home/js/waitMe.min.js')}}"></script>
    <script>
    function open_loader(container) {
        $(container).waitMe({
            effect : 'bounce',
            text : '',
            bg : 'rgba(255,255,255,0.7)',
            color : '#000',
            maxSize : '',
            waitTime : '-1',
            textPos : 'vertical',
            fontSize : '',
            source : '',
            onClose : function() {}
        });
    }

    function close_loader(container) {
        $(container).waitMe("hide");
    }
    </script>


    @yield('script')


    <script>
       $('#news-form').submit(function(e){
		e.preventDefault();
        open_loader('#page');

		var form = $("#news-form")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url("/home/ajax/newsletter")}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
				if(data.status == "success"){
					toastr.success(data.message, data.status);
					window.setTimeout(function(){location.reload();},3000);
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


</body>
</html>

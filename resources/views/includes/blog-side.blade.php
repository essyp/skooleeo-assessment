<div class="col-md-3 col-sm-12 col-12">
    <div class="blog-post-right">
        <form action="/blog/search-blog" method="post">
            {{ csrf_field() }}
        <div id="search-input">
            <div class="input-group">
                <input type="text" name="q" class="form-control input-sn" placeholder="Search blog..."/>
                <span class="input-group-btn">
                    <button class="btn btn-info btn-md" type="submit"><i class="fa fa-search"></i></button>
                </span>

            </div>
        </div>
            </form>
        <h4 class="blog-widget-title">Blog Categories</h4>
        <div class="blog-post-categories mt-20">
            <ul>
                @foreach($category as $blogcat)
                <li><a href="{{url('blog/category/'.$blogcat->slug)}}">{{$blogcat->name}}<span></span></a></li>
                @endforeach
            </ul>
        </div>
        <h4 class="blog-widget-title">Featured News</h4>
        <div class="top-news mt-20">
            @foreach ($blogfeatured as $blog)
            <div class="top-news-info">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-12 pr-0">
                        <img src="{{asset('images/blog/'.$blog->image)}}" alt="img">
                    </div>
                    <div class="col-md-8 col-sm-8 col-12">
                        <h3><a href="{{url('blog/'.$blog->slug)}}">{{$blog->title}}</a></h3>
                        <h6> {{date("F d, Y",strtotime($blog->created_at))}}</h6>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        
       <h4 class="blog-widget-title">Connect With Us</h4>
        <div class="blog-post-follow mt-20">
            <ul>
                <li class="social-link"><a href="" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-link"><a href="" target="_blank"><i class="fab fa-youtube"></i></a></li>
                <li class="social-link"><a href="" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li class="social-link"><a href="" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li class="social-link"><a href="" target="_blank"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
</div>

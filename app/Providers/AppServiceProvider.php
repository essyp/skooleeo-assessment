<?php

namespace App\Providers;
define('ACTIVE','1');
define('INACTIVE','2');
define('COMPLETED','3');
define('CANCELED','4');
define('PROCESSING','5');
define('PROCESSED','6');
define('YES','1');
define('NO','2');
define('ADMIN','1');
define('SUPER_ADMIN','2');
define('MANAGER','3');
define('SUCCESSFUL','1');
define('UNSUCCESSFUL','2');
define('USER','2');
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\BlogCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); 

        $footerblog = Blog::where('status',1)->where('featured',1)->limit(2)->get();
        view()->share('footerblog',$footerblog);

        $blogfeatured = Blog::where('status',1)->where('featured',1)->limit(4)->get();
        view()->share('blogfeatured',$blogfeatured);

        $category = BlogCategory::where('status',1)->get();
        view()->share('category',$category);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

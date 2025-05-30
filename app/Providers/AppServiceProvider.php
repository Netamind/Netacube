<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Blade::directive('convert', function ($money) { 
            return "<?php 
                \$value = is_numeric($money) ? $money : 0; 
                echo number_format(\$value, 0); 
            ?>"; 
        });


        Blade::directive('convert2', function ($money) { 
            return "<?php 
                \$value = is_numeric($money) ? $money : 0; 
                echo number_format(\$value, 2); 
            ?>"; 
        });

    }


    
}

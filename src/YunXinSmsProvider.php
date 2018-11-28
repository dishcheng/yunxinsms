<?php

namespace DishCheng\YunXinSms;

use Illuminate\Support\ServiceProvider;

class YunXinSmsProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/config/yunxinsms.php' => config_path('yunxinsms.php'),],
            'yunxinsms'
        );
    }

    public function register()
    {

        $this->mergeConfigFrom(__DIR__ . '/config/yunxinsms.php', 'aliyunsms');

        $this->app->bind(YunXinSms::class, function () {
            return new YunXinSms();
        });
    }
}

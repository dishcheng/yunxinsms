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
            __DIR__ . '/../config' => config_path(),],
            'yunxinsms'
        );
    }

    public function register()
    {
        $this->app->bind(YunXinSms::class, function () {
            return new YunXinSms();
        });
    }
}

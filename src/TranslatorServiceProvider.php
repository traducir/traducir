<?php

namespace Traducir\Traducir;

use Illuminate\Support\ServiceProvider;
use Traducir\Traducir\Contracts\Factory;

class TranslatorServiceProvider extends ServiceProvider
{

  // protected $defer = true;

  /**
  * Booting Laravel ServiceProvider
  */
  public function boot()
  {
    $this->publishes([
      __DIR__.'/../translator.php' => config_path('translator.php'),
    ]);
  }

  /**
  * Register Package Instance
  */
  public function register()
  {
      $this->app->singleton(Factory::class, function ($app) {
        return new Translator(
          $this->app['config']['translator']
        );
      });
  }

  public function provides()
  {
    return [Factory::class];
  }

}

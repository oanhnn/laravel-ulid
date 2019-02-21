<?php

namespace Laravel\Ulid;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package     Laravel\Ulid
 * @author      Oanh Nguyen <oanhnn.bk@gmail.com>
 * @license     The MIT license
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // other booting ...
        Blueprint::macro('ulid', function (Blueprint $table) {
            return $table->char(26);
        });
    }
}

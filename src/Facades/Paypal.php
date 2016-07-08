<?php

namespace Sger\Paypal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the Paypal facade class.
 *
 * @author Spiros Gerokostas <spiros.gerokostas@gmail.com>
 */
class Paypal extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'paypal';
    }
}

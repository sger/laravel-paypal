<?php

/*
 * This file is part of Laravel Paypal.
 *
 * (c) Spiros Gerokostas <spiros.gerokostas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sger\Paypal;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class PaypalManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Sger\Paypal\PaypalFactory
     */
    private $factory;

    /**
     * Create a new Paypal manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param Sger\Paypal\PaypalFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, PaypalFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'paypal';
    }

    /**
     * Get the factory instance.
     *
     * @return \Sger\Paypal\PaypalFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}

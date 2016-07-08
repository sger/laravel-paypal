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

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalFactory
{
    /**
     * Make a new Paypal client.
     *
     * @param array $config
     *
     * @return PayPal\Rest\ApiContext
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }


    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config)
    {
        $keys = ['client_id', 'client_secret'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException("Missing configuration key [$key].");
            }
        }

        return array_only($config, ['client_id', 'client_secret']);
    }

    /**
     * Get the Paypal client.
     *
     * @param array $auth
     *
     * @return PayPal\Rest\ApiContext
     */
    protected function getClient(array $auth)
    {
        $credentials = new OAuthTokenCredential($auth['client_id'], $auth['client_secret']);
        return new ApiContext($credentials);
    }
}

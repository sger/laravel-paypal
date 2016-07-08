<?php

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
     * @return 
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

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

    protected function getClient(array $auth)
    {
        $credentials = new OAuthTokenCredential($auth['client_id'], $auth['client_secret']);
        return new ApiContext($credentials);
    }
}

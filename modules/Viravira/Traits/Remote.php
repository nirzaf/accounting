<?php

namespace Modules\Viravira\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait Remote
{

    protected static function getCustomers($method)
    {
        $url = 'customer/' . $method;

        $response = static::getRemote($url);

        if ($response && ($response->getStatusCode() == 200)) {
            $result = json_decode($response->getBody());

            return $result;
        }

        return [];
    }

    protected static function getProducts($method)
    {
        $url = 'product/' . $method;

        $response = static::getRemote($url);

        if ($response && ($response->getStatusCode() == 200)) {
            $result = json_decode($response->getBody());

            return $result;
        }

        return [];
    }

    protected static function getOrders()
    {
        $url = 'order/getOrders';

        $response = static::getRemote($url);

        if ($response && ($response->getStatusCode() == 200)) {
            $result = json_decode($response->getBody());

            return $result;
        }

        return [];
    }

    protected static function getRemote($url, $form_params = array())
    {
        $base = 'http://api.viravira.com/';

        try {
            $client = new Client(['verify' => false, 'base_uri' => $base]);
        } catch (RequestException $e) {
            $result = $e;
        }

        $form_params['token'] = setting('viravira.token');

        if (!isset($form_params['limit'])) {
            $form_params['limit'] = 500;
        }

        $data = [
            'form_params' => $form_params
        ];

        try {
            $result = $client->post($url, $data);
        } catch (RequestException $e) {
            $result = $e;
        }

        return $result;
    }
}

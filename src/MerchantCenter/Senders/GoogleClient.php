<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Senders;

use Google;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use Saloon\Http\Senders\GuzzleSender;

class GoogleClient extends GuzzleSender
{
    public function __construct(protected array $config)
    {
        parent::__construct();
    }

    protected function createGuzzleClient(): GuzzleClient
    {
        $this->handlerStack = HandlerStack::create();

        $client = new Google\Client();
        $client->setAuthConfig($this->config['credentials']);
        $client->addScope($this->config['scopes']);

        return $client->authorize();
    }
}

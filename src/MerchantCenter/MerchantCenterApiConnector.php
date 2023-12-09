<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter;

use Saloon\Contracts\Sender;
use Saloon\Http\Connector;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Senders\GoogleClient;

class MerchantCenterApiConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://shoppingcontent.googleapis.com/content/v2.1/'.config('gmc.merchant_id');
    }

    protected function defaultSender(): Sender
    {
        $config = config('gmc');
        return new GoogleClient($config);
    }
}

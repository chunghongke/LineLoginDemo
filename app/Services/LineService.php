<?php
namespace App\Services;

use Illuminate\Support\Facades\Config;

class LineService
{
    public function getLineLoginBaseUrl()
    {
        // 組成 Line Login Url
        $url = Config::get('app.line_authorize_url'). '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' .Config::get('app.line_channel_id');
        $url .= '&redirect_uri=' . Config::get('app.url') . ':3000/line/callback';
        $url .= '&state=test'; // 暫時固定方便測試
        $url .= '&scope=openid%20profile';

        return $url;
    }
}

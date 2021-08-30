<?php

namespace App\Services;

use GuzzleHttp\Client;

class LineService
{
    public function getLoginBaseUrl()
    {
        // 組成 Line Login Url
        $url = config('app.line_authorize_url') . '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' . config('app.line_channel_id');
        $url .= '&redirect_uri=' . config('app.line_redirect_url');
        $url .= '&state=test'; // 暫時固定方便測試
        $url .= '&scope=openid%20profile';

        return $url;
    }

    public function getToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', config('app.line_token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('app.line_redirect_url'),
                'client_id' => config('app.line_channel_id'),
                'client_secret' => config('app.line_channel_secret')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUserProfile($token)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $client->request('GET', config('app.line_user_profile_url'), [
            'headers' => $headers
        ]);
        return $response->getBody()->getContents();
    }
}

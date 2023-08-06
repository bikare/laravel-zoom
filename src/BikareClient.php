<?php
namespace Bikare\LaravelZoom;

use GuzzleHttp\Client;

class BikareClient
{
    protected string $accessToken;
    protected $client;
    protected $account_id;
    protected $client_id;
    protected $client_secret;

    public function __construct()
    {

        if (auth()->check()) {
            $user = auth()->user();
            $this->client_id = method_exists($user, 'clientID') ? $user->clientID() : config('zoom.client_id');
            $this->client_secret = method_exists($user, 'clientSecret') ? $user->clientSecret() : config('zoom.client_secret');
            $this->account_id = method_exists($user, 'accountID') ? $user->accountID() : config('zoom.account_id');
        } else {
            $this->client_id = config('zoom.client_id');
            $this->client_secret = config('zoom.client_secret');
            $this->account_id = config('zoom.account_id');
        }

        $this->accessToken = $this->getAccessToken();

        $this->client = new Client([
            'verify' => false,
            'base_uri' => 'https://api.zoom.us/v2/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function getAccessToken()
    {
        $client = new Client([
            'verify' => false,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->client_id . ':' . $this->client_secret),
                'Host' => 'zoom.us',
            ],
        ]);

        $response = $client->request('POST', "https://zoom.us/oauth/token", [
            'form_params' => [
                'grant_type' => 'account_credentials',
                'account_id' => $this->account_id,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['access_token'];
    }

    public function biRequest($method, array $data,$uri)
    {
        try {
            $response = $this->client->request($method, $uri, [
                'json' => $data,
            ]);
            $res = json_decode($response->getBody(), true);
            return [
                'status' => true,
                'http_status' => $response->getStatusCode(),
                'data' => $res,
            ];
        }
        catch (\Throwable $th) {
            return [
                'status' => false,
                'http_status' => $th->getCode(),
                'data' => $th->getMessage(),
            ];
        }
    }
}

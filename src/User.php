<?php
namespace Bikare\LaravelZoom;

use GuzzleHttp\Client;

class User
{
    protected $client;
    public function __construct()
    {
        $this->client = new BikareClient();
    }
    public function create($user)
    {
        $data = [
            'action' => 'create',
            'user_info' => [
                'email' => $user['email'],
                'first_name'=> $user['name'],
                'last_name' => $user['surname'],
                'password' => $user['password'],
                'type'=> 1
            ]
        ];
        $response = $this->client->biRequest('POST',$data,'users');
        return $response;
    }
    public function update($user)
    {
        $data = [
            'first_name'=> $user['name'],
            'last_name' => $user['surname'],
        ];
        $response = $this->client->biRequest('PATCH',$data,'users/'.$user['id'].'');
        return $response;
    }
    public function pass_update($user)
    {
        $data = [
            'password'=> $user['password'],
        ];
        $response = $this->client->biRequest('PUT',$data,'users/'.$user['id'].'/password');
        return $response;
    }
    public function email_update($user)
    {
        $data = [
            'email'=> $user['email']
        ];
        $response = $this->client->biRequest('PUT',$data,'users/'.$user['id'].'/email');
        return $response;
    }
}

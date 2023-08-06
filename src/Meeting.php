<?php

namespace Bikare\LaravelZoom;


class Meeting
{
    private $client;
    public function __construct()
    {
        $this->client = new BikareClient();
    }
    public function create($customer,$authorized,$meet)
    {
        $data = [
            'topic' => $meet['topic'],
            'default_password'=>false,
            'start_time' => $meet['time'],
            'duration' => $meet['duration'],
            'host_email'=> $authorized['email'],
            'timezone' => 'Europe/Istanbul',
            "type"=> 2,
            'authentication_exception' => [
                'email' => $customer['email'],
                'name' => $customer['name'].''.$customer['surname']
            ],
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'audio' => true,
                'approval_type' => 2,
                'waiting_room' => true,
                'join_before_host' => true
            ],
        ];
        $response = $this->client->biRequest('POST',$data,'users/'.$authorized['userId'].'/meetings');
        return $response;
    }
    public function update($meet_id,$meet)
    {
        $data = [
            'topic' => $meet['topic'],
            'start_time' => $meet['topic']
        ];
        $response = $this->client->biRequest('PATCH',$data,'meetings/'.$meet_id.'');
        return $response;
    }
    public function delete($meet_id)
    {
        $response = $this->client->biRequest('DELETE',[],'meetings/'.$meet_id.'');
        return $response;
    }
}

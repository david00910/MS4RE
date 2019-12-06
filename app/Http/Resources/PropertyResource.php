<?php

namespace App\Http\Resources;

use App\Property;
use GuzzleHttp\Client;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $address_id = $this->address_id;

        $client = new Client();
        $response = $client->request('GET', 'https://dawa.aws.dk/adresser/'.$address_id.'?struktur=mini');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();


        return [

        ];
    }
}

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

            'id' => $this->id,
            'description' => $this->description,
            'price' => $this->price,
            'brutto' => $this->brutto,
            'netto' => $this->netto,
            'own_exp' => $this->own_exp,
            'deposit' => $this->deposit,
            'sqm_price' => $this->sqm_price,
            //'category' => $this->propertycategories(),
            //'files' => $this->files(),
            'address' => json_decode($body),
            'api_status' => $statusCode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}

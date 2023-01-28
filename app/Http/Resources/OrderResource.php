<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "id" => $this->id,    
            "name" => $this->customer_name,
            "address" => $this->customer_address,                                 
            "orders" => $this->orders,
            "tite" => $this->getTite,
            "customer_id" => $this->customer_id,                    
        ];
    }
}

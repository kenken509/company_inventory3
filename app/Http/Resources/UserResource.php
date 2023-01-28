<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "name" => $this->name,    
            "picture" => $this->profile_image,               
            "email" => $this->email,
            "role" => $this->role,    
            "cart" => CartItemResource::collection($this->cartItems),    
            "mobile_no" => $this->mobile_no,    
        ];
    }
}

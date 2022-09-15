<?php

namespace App\Http\Resources\Demo\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class RestFulApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_code' => $this->product_code,
'product_price_new' => $this->product_price_new,
            'product_status' => $this->product_status == 0 ? 'Ẩn' : "Hiển thị",
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}

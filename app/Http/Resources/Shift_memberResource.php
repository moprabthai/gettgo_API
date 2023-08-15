<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Shift_memberResource extends JsonResource
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
            'shift_member_id'=>$this->shift_member_id,
            'shift_id'=>$this->shift_id,
            'employee'=>$this->employee,
            'shift'=>$this->shift,

        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'action_by'=>(string)$this->action_by,
            'comment'=>$this->comment,
            'created_at'=>$this->created_at,
            'id'=>$this->id,
            'requestStatus'=>$this->requestStatus,
            'request_ot_id'=>$this->request_ot_id,
            'updated_at'=>$this->updated_at,
            'empinfo'=>$this->empinfo
        ];
    }
}

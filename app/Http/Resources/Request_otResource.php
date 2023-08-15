<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Request_otResource extends JsonResource
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
        $detail = $this->Request_ot_Details;
        $myArray = [];
        foreach ($detail as $item) {
            array_push($myArray, (object)[
                'no' => $item['no'],
                'time_start' => ($item['time_start'] != '')?Carbon::createFromFormat('Y-m-d H:i:s',$item['time_start'])->format('d-m-Y H:i'):'',
                'time_end' => ($item['time_end'] != '')? Carbon::createFromFormat('Y-m-d H:i:s',$item['time_end'])->format('d-m-Y H:i'):'',
                'type' => $item['type'],
                'price_of_hours' => $item['price_of_hours'],
                'total_hours' => $item['total_hours'],
                'total_price' => $item['total_price'],
                'note' => ($item['note']==1)?true:false,
                'comment' => $item['comment'],
            ]);
        }
        return [

            'Header' => [
                'id' => $this->id,
                "requestNo" => $this->requestNo,
                'requestStatus_No' => $this->requestStatus_No,
                "requestStatus" => $this->requestStatus,
                "requestDate" => Carbon::createFromFormat('Y-m-d',$this->requestDate)->format('d/m/Y'),
                "employeeID" => $this->employeeID,
                "department" => $this->department,
                "employeeName" => $this->employeeName,
                "approverName" => $this->approverName,
                "approverID" => $this->approverID,
                "salary" => $this->salary,
                "price_of_hours" => $this->price_of_hours,
                "shift" => $this->shift,
                "shiftTime" => $this->shiftTime,
                "shiftBreak" => $this->shiftBreak,
                "shiftWeekend" => $this->shiftWeekend,
                "shiftMinus_hours"=>$this->shiftMinus_hours,
                "assignTo"=>(string)$this->assignTo
            ],
            'total' => [
                "price" => $this->totalprice_ot
            ],
            // 'Detail' => $this->Request_ot_Details,
            'Detail' => $myArray,

        ];
    }
}
class Request_otResource_2 extends JsonResource{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

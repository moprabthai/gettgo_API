<?php

namespace App\Http\Resources;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'emp_id'=>(string)$this->emp_id,
            'fname'=>(string)$this->fname,
            'lname'=>(string)$this->lname,
            'salary'=>(string)$this->salary,
            'department'=>$this->department,
            'email'=>(string)$this->email,
            'password'=>(string)$this->password,
            'isadmin'=>(string)$this->isadmin,
            'active'=>(string)$this->active,

        ];

    }
}

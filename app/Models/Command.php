<?php

namespace App\Models;

use App\Http\Resources\EmployeeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class,'emp_id','emp_id');
    }
    public function approver()
    {
        return $this->belongsTo(Approver::class,'group_id','group_id');
    }

}

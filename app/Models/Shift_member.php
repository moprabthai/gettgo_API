<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift_member extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class,'emp_id','emp_id');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id','shift_id');
    }
}

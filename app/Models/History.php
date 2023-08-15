<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function empinfo()
    {
        return $this->belongsTo(Employee::class,'action_by','emp_id');
    }
}

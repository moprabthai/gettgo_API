<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function department()
    {
        return $this->belongsTo(Department::class,'dep_id','dep_id');
    }
    public function employee()
    {
        return $this->hasMany(Command::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_ot extends Model
{

    use HasFactory;
    protected $guarded = [];
    public function Request_ot_Details()
    {
     return $this->hasMany(Request_ot_Detail::class,'request_ot_id','id');
    }


}

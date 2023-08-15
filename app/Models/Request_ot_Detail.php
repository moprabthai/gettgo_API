<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_ot_Detail extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Request_ot()
    {
        // return $this->belongsTo(Request_ot::class,'request_ot_id','id');
    }
}

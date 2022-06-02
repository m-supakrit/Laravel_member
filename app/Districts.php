<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $fillable=['districts_id','districts_code','districts_name','postcode','geo_id','province_id'];  
}

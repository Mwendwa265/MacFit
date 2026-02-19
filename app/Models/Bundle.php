<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
   protected $fillable =[
        "name" ,
        "description",
        "start_time",
        "duration",
        "category_id"
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subscription extends Model
{
   protected $fillables = [
        'user_id',
        'bundle_id',
   ];

   
}

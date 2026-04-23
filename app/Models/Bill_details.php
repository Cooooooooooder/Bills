<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill_details extends Model
{
       public function section_of_bill_details()
    {
        return $this->belongsTo(sections::class, 'section_id');
    }
}

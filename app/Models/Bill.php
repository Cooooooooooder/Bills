<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    public function section_of_bill()
    {
        return $this->belongsTo(sections::class, 'section_id');
    }
    public function product_of_bill()
    {
        return $this->belongsTo(Product::class, 'product');
    }
}

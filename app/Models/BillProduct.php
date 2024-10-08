<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bill_id',
        'price',
        'quantity'
    ];

    public function bill(){
        return $this->belongsTo(Bill::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}

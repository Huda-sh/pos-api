<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'discount'
    ];

    public function billProducts() {
        return $this->hasMany(BillProduct::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

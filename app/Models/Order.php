<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // protected $primaryKey = 'order_id';

    // protected $fillable = ['customer_id', 'order_date'];

    // public function customer()
    // {
    //     return $this->belongsTo(Customers::class, 'customer_id', 'customer_id');
    // }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    // }

    protected $primaryKey = 'order_id';

protected $fillable = ['customer_id', 'order_date'];

public function customer()
{
    return $this->belongsTo(Customers::class, 'customer_id', 'customer_id');
}

public function orderDetails()
{
    return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
}


    // protected $table = 'orders';
    // protected $primaryKey = 'order_id'; // 🔥 VERY IMPORTANT
    // public $incrementing = true;
    // protected $keyType = 'int';
    // public $timestamps = false;

    // protected $fillable = [
    //     'customer_id',
    //     'order_date'
    // ];
}

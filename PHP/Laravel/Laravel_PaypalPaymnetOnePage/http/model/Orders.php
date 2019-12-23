<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model{
    protected $table="orders";
    protected $fillable=[
        'customer_name', 
        'email','phone', 
        'address', 
        'message', 
        'regarding_payment',
        'payment_txn_id',
        'status',
        'amount',
        'payment_order_id'
    ];
}
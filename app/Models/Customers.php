<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}

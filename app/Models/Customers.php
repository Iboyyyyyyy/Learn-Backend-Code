<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'contact_name',
        'email',
        'password',
        'address',
        'city',
        'postal_code',
        'country',
    ];
}

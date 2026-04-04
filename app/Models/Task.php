<?php

namespace App\Models;


class Task extends BaseModel
{
    protected $fillable = [
        'title',
        'status'
    ];

    public function getStatusColor()
    {
        return match($this->status) {
            'pending' => 'text-yellow-500',
            'completed' => 'text-green-500',
            'in_progress' => 'text-blue-500',
            'cancelled' => 'text-red-500',
            default => 'text-gray-500',
        };
    }
}

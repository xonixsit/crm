<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'primary_phone',
        'email',
        'company',
        'website',
        'status',
        'assigned_user_id',
    ];

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'lead_user', 'lead_id', 'user_id');
    }
}
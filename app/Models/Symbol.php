<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Symbol extends Model
{
    use HasFactory;

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}

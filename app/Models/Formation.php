<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    public function candidat()
    {
        return $this->belongsToMany(User::class)->withPivot('status', 'id');
    }
}

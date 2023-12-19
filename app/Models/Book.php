<?php

namespace App\Models;

// Rest of the code for the Book class


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function review() {
        return $this->hasMany(Review::class);
    }
}

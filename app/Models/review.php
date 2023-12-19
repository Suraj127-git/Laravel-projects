<?php

namespace App\Models;

// Rest of the code for the Book class

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    public function book() {
        return $this->belongsTo(Book::class);
    }
}

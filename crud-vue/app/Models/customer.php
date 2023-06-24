<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = "customers";
    protected $primary_key = "id";

    protected $fillable = [
        'name', // Add the 'name' attribute to the fillable array
        'email'
    ];
}

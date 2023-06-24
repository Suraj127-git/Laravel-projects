<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index()
    {
        Redis::set('user:1:first_name', 'suraj');
        Redis::set('user:2:first_name', 'asta');
        Redis::set('user:3:first_name', 'luffy');
        Redis::set('user:4:first_name', 'goku');
        Redis::set('user:5:first_name', 'naruto');
    }

    public function show()
    {
        for($i = 0; $i < 6; $i++)
        {
           echo Redis::get('user:' . $i . ':first_name').'<br>';
        }
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test method works!']);
    }
}

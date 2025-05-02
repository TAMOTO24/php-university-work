<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('role:Admin')->only('adminDashboard');
        $this->middleware('role:Manager')->only('managerDashboard');
        $this->middleware('role:Client')->only('clientDashboard');
    }

    public function adminDashboard()
    {
        return response()->json(['message' => 'Welcome Admin']);
    }

    public function managerDashboard()
    {
        return response()->json(['message' => 'Welcome Manager']);
    }

    public function clientDashboard()
    {
        return response()->json(['message' => 'Welcome Client']);
    }
}


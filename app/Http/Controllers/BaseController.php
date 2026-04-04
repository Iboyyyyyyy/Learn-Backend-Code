<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

// use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct()
    {
        View::share('appName', 'TaskMaster Pro');
    }
}

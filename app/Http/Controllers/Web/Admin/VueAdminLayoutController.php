<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VueAdminLayoutController extends Controller
{
    public function layout()
    {
        return view('web.admin.vueapp.layout');
    }
}

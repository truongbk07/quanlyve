<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileveController extends Controller
{
    public function thongtinve()
    {
        return view('thongtinve');
    }

    public function xulyve(Request $request)
    {
        $noidungemail = $request->noidungemail;

        echo $noidungemail;
    }
}

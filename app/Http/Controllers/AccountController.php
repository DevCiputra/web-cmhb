<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $title = 'Akun Saya';
        return view('account.contents.index', compact('title'));
    }
}

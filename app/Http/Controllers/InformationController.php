<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function indexArticle()
    {
        return view('management-data.information.article.index');
    }

    

    public function indexPromote()
    {
        return view('management-data.information.promote.index');
    }

    public function create()
    {
        return view('management-data.information.promote.create');
    }

}

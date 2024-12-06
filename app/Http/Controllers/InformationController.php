<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\InformationCategory;
use App\Models\InformationLog;
use App\Models\InformationMedia;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function indexArticle()
    {
        return view('management-data.information.article.index');
    }

    public function createArticle()
    {

        $categories = InformationCategory::all();
        return view('management-data.information.article.create', compact('categories'));
    }

    public function editArticle()
    {
        return view('management-data.information.article.edit');
    }

    public function detailArticle()
    {
        return view('management-data.information.article.detail');
    }

    
// PROMOSI
    public function indexPromote()
    {
        return view('management-data.information.promote.index');
    }

    public function createPromote()
    {

        $categories = InformationCategory::all();
        return view('management-data.information.promote.create', compact('categories'));
    }

    public function editPromote()
    {
        return view('management-data.information.promote.edit');
    }

}

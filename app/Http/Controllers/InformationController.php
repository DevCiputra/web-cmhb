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

    // INFORMATION CATEGORIES
    public function indexCategory()
    {
        $categories = InformationCategory::all();
        return view('management-data.information.category.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('management-data.information.category.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        InformationCategory::create($validated);
        return redirect()->route('information.category.index')->with('success', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = InformationCategory::findOrFail($id);
        return view('management-data.information.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = InformationCategory::findOrFail($id);
        $category->update($validated);

        return redirect()->route('information.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        $category = InformationCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('information.category.index')->with('success', 'Category deleted successfully.');
    }


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

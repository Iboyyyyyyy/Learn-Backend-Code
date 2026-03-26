<?php

namespace App\Http\Controllers;
use App\Models\Categories;

// use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function category(){
        $categories = Categories::all();
        return view('welcome', compact('categories'));
    }
}

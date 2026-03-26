<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Categories::all();
        return response()->json($categories);
    }


    // POST create
    public function store(Request $request){
        $category = Categories::create($request->all());
        return response()->json($category, 201);
    }


    // GET single
    public function show($id){
        return response()->json(Categories::findOrFail($id));
    }

    // PUT update
    public function update(Request $request, $id){
        $category = Categories::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    // DELETE
    public function destroy($id){
        Categories::destroy($id);
        return response()->json(null, 204);
    }


}

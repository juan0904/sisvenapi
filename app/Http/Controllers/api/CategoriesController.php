<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return json_encode(['categories' => $categories]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => ['required', 'max:30']
        ]);
        $categorie = new Categories();
        $categorie->id = $request->id;
        $categorie->name = $request->name;
        $categorie->description = $request->description;
        $categorie->save();

        return json_encode(['categorie' => $categorie]);  

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie= Categories::find($id);
        if(is_null($categorie)){
            return abort(404);
        }
        
        return json_encode(['categorie' => $categorie]);  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categorie = Categories::find($id);
        $categorie->id = $request->id;
        $categorie->name = $request->name;
        $categorie->description = $request->description;
        $categorie->save();
        
        return json_encode(['categorie' => $categorie]);  

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = Categories::find($id);
        $categorie->delete();

        $categories = Categories::all();
        return json_encode(['categories' => $categories, 'success' => true]);  

    }
}
<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.category_id') 
        ->select('products.*',  'categories.name as category')
        ->get();
    
    return json_encode(['products' => $products]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'name' => ['required', 'max:30']
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        return json_encode(['product' => $product]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product= Product::find($id);
        if(is_null($product)){
            return abort(404);
        }
        $categories = DB::table('categories')->orderBy('name')->get();
        return json_encode(['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, string $id)
        {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;

            $product->save();
            return json_encode(['product' => $product]);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Product::find($id);
        $producto->delete();

        $products = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.category_id') 
        ->select('products.*',  'categories.name as category')
        ->get();
        return json_encode(['products' => $products, 'success' => true]);
    }
}

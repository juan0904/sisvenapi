<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\paymode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymodes = paymode::all();
        return json_encode(['paymodes' => $paymodes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => ['required', 'max:30']
        ]);
        $paymode = new paymode();
        $paymode->id = $request->id;
        $paymode->name = $request->name;
        $paymode->observation = $request->observation;
        $paymode->save();

        return json_encode(['paymode' => $paymode]);  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymode= paymode::find($id);
        if(is_null($paymode)){
            return abort(404);
        }
        
        return json_encode(['paymode' => $paymode]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paymode = paymode::find($id);
        $paymode->id = $request->id;
        $paymode->name = $request->name;
        $paymode->observation = $request->observation;
        $paymode->save();
        
        return json_encode(['paymode' => $paymode]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymode = paymode::find($id);
        $paymode->delete();

        $paymodes = paymode::all();
        return json_encode(['paymodes' => $paymodes, 'success' => true]); 
    }
}

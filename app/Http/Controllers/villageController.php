<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class villageController extends Controller
{
    public function index(Request $request)
    {
        $village = $request->village;
        $data = User::where('village', $village)->get(); // Adjust the model and query as necessary

        return response()->json($data);
    }
}

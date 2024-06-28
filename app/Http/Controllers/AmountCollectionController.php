<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collection;

class AmountCollectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string', // Don't check existence here, handle it separately
            'amount' => 'required|numeric',
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $collection = new Collection();
        $collection->name = $request->name;
        $collection->amount = $request->amount;
        $collection->save();

        return response()->json(['message' => 'Amount added successfully'], 201);
    }

    public function getTotalAmount()
    {
        $totalAmount = Collection::sum('amount');
        return response()->json(['total_amount' => $totalAmount], 200);
    }

}

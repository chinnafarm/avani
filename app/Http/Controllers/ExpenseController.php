<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expense::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // This method is not typically used in API controllers
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $expense = Expense::create($request->all());

        return response()->json($expense, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        // Find the user first
        $user = User::where('name', $name)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Calculate the total amount spent by the user
        $totalAmount = Expense::where('name', $name)->sum('amount');

        // Fetch all expenses for the user
        $expenses = Expense::where('name', $name)->get();

        return response()->json([
            'user' => $name,
            'total_amount' => $totalAmount,
            'expenses' => $expenses
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        // This method is not typically used in API controllers
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'product_name' => 'sometimes|string|max:255',
            'amount' => 'sometimes|numeric',
            'date' => 'sometimes|date',
        ]);

        $expense = Expense::where('name', $name)->first();

        if (!$expense) {
            return response()->json(['error' => 'Expense not found'], 404);
        }

        $expense->update($request->all());

        return response()->json($expense, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $expense = Expense::where('name', $name)->first();

        if (!$expense) {
            return response()->json(['error' => 'Expense not found'], 404);
        }

        $expense->delete();

        return response()->json(null, 204);
    }
}

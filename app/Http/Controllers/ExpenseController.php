<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'expenses' => Expense::all()
        ]);
    }
    public function store(Request $request)
    {
        //Validate all required fields
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'spent_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        //Create the expense using validate data
        Expense::create($validated);

        //reason kenapa on Network dia redirect (302) sebab kita redirect balik ke dashboard
        return redirect()->route('dashboard')->with('success', 'Expense created successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('dashboard')->with('success', 'Expense deleted successfully.');
    }

    public function edit(Expense $expense)
    {
        return view('dashboard', [
            'expenses' => Expense::all(),
            'editingExpense' => $expense
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate(rules: [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'spent_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('dashboard')->with('success', 'Expense updated successfully.');
    }

}

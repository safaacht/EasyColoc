<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index($colocationId)
    {
        $colocation = Colocation::findOrFail($colocationId);
        $expenses = $colocation->expenses()->with(['user', 'category'])->get();
        $categories = Category::with('name')->get();
        
        return view('expenses.index', compact('colocation', 'expenses', 'categories'));
    }

    public function store(Request $request, $colocationId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:category,id',
        ]);

        $colocation = Colocation::findOrFail($colocationId);

        $colocation->expenses()->create([
            'amount' => $validated['amount'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('colocations.expenses.index', $colocationId)
                         ->with('success', 'Expense added successfully.');
    }

    public function destroy(Expense $expense)
    {
        $colocationId = $expense->colocation_id;
        $expense->delete();

        return redirect()->route('expenses.index', $colocationId)
                         ->with('success', 'Expense deleted successfully.');
    }
}

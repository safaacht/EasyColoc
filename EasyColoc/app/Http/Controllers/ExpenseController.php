<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseRequest;

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

    public function store(StoreExpenseRequest $request, $colocationId)
    {
        $validated = $request->validated();

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

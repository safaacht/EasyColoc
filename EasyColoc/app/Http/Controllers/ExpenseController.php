<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseRequest;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Category;
use App\Models\Settlement;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index($colocationId)
    {
        $colocation = Colocation::findOrFail($colocationId);
        $expenses = $colocation->expenses()->with(['user', 'category'])->get();
        $categories = Category::where('colocation_id', $colocationId)->get();
        
        return view('expenses.index', compact('colocation', 'expenses', 'categories'));
    }

    public function store(StoreExpenseRequest $request, $colocationId)
    {
        $validated = $request->validated();

        $colocation = Colocation::findOrFail($colocationId);

        $colocation->expenses()->create([
            'amount' => $validated['amount'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'user_id' => Auth::id(),
        ]);

        if (class_exists(Settlement::class)) {
            Settlement::recalculateForColocation($colocationId);
        }

        return redirect()->back()->with('success', 'Expense added successfully.');
    }

    public function destroy(Expense $expense)
    {
        $colocationId = $expense->colocation_id;
        $expense->delete();

        if (class_exists(Settlement::class)) {
            Settlement::recalculateForColocation($colocationId);
        }

        return redirect()->back()->with('success', 'Expense deleted successfully.');
    }
}

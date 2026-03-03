<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Settlement;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        //  active colocation (where user is currently joined)
        $activeColocation = $user->colocations()->wherePivot('status', 'joined')->first();
        
        $myBalance = 0;
        $totalExpenses = 0;
        $mySettlements = [];
        $monthlyExpenses = [0, 0, 0, 0, 0]; //5 months

        if ($activeColocation) {
            // calcule du balance
            //  (receiver)
            $owedToMe = Settlement::where('colocation_id', $activeColocation->id)
                ->where('receiver_id', $user->id)
                ->where('payed', false)
                ->sum('amount');
            
            // amount you OWE (payer)
            $iOwe = Settlement::where('colocation_id', $activeColocation->id)
                ->where('payer_id', $user->id)
                ->where('payed', false)
                ->sum('amount');
            
            $myBalance = $owedToMe - $iOwe;

            // Total Expenses in this Colocation
            $totalExpenses = Expense::where('colocation_id', $activeColocation->id)->sum('amount');

            //  (who owes what)
            $mySettlements = Settlement::with(['payer', 'receiver'])
                ->where('colocation_id', $activeColocation->id)
                ->where('payed', false)
                ->where(function($query) use ($user) {
                    $query->where('payer_id', $user->id)
                          ->orWhere('receiver_id', $user->id);
                })
                ->get();

           
            $monthlyExpenses = Expense::where('colocation_id', $activeColocation->id)
                ->where('created_at', '>=', now()->subMonths(5))
                ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total')
                ->toArray();
            
            
            while(count($monthlyExpenses) < 5) {
                array_unshift($monthlyExpenses, 0);
            }
        }

        return view('dashboard', [
            'colocation' => $activeColocation,
            'myBalance' => $myBalance,
            'totalExpenses' => $totalExpenses,
            'mySettlements' => $mySettlements,
            'monthlyExpenses' => $monthlyExpenses,
        ]);
    }
}

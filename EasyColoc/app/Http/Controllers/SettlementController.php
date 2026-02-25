<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settlement;
use App\Models\Colocation;

class SettlementController extends Controller
{
    public function index($colocationId)
    {
        $colocation = Colocation::findOrFail($colocationId);
        $settlements = Settlement::where('colocation_id', $colocationId)
                                  ->with(['payer', 'receiver'])
                                  ->get();

        return view('settlments.index', compact('colocation', 'settlements'));
    }

    public function markAsPayed(Settlement $settlement)
    {
        $settlement->update(['payed' => true]);

        return back()->with('success', 'Settlement marked as payed.');
    }
}

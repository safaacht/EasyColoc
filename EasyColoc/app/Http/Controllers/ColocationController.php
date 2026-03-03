<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;

use App\Models\Colocation;
use App\Models\User;
use App\Models\Category;
use App\Models\Settlement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    public function index()
    {
        $colocations = Auth::user()->colocations;
        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        if (Auth::user()->ownsAnyColocation()) {
            return redirect()->route('colocations.index')->with('error', 'You already own a colocation. You can only own one at a time.');
        }
        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->ownsAnyColocation()) {
            return redirect()->route('colocations.index')->with('error', 'You already own a colocation.');
        }

        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $colocation = Colocation::create($validated);
            
            $user = Auth::user();
            $colocation->members()->attach($user->id, [
                'type' => 'owner',
                'status' => 'joined',
                'solde' => 0,
            ]);

            if ($user->role !== 'admin') {
                $user->update(['role' => 'owner']);
            }
        });

        return redirect()->route('colocations.index')->with('success', 'Colocation created successfully.');
    }

    public function show(Colocation $colocation)
    {
        $colocation->load(['members', 'expenses.user', 'expenses.category']);
        
        // only show categories for this colocation
        $categories = Category::where('colocation_id', $colocation->id)->get();
        
        //  available users to invite
        $availableUsers = User::whereIn('role', ['membregenerale', 'admin'])
            ->whereDoesntHave('memberships', function($query) {
                $query->where('status', 'joined');
            })->get();

        // fetch settlements from DB
        $settlements = Settlement::where('colocation_id', $colocation->id)
            ->where('payed', false)
            ->with(['payer', 'receiver'])
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'from' => $s->payer->name,
                    'to' => $s->receiver->name,
                    'amount' => $s->amount
                ];
            });
        return view('colocations.show', compact('colocation', 'categories', 'settlements', 'availableUsers'));
    }

    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $validated = $request->validated();

        $colocation->update($validated);

        return redirect()->route('colocations.index')->with('success', 'Colocation updated successfully.');
    }

    public function destroy(Colocation $colocation)
    {
        // owner ends colocation (only owner)
        if (!Auth::user()->ownsColocation($colocation)) {
            return redirect()->back()->with('error', 'Only the owner can end the colocation.');
        }

        $colocation->update(['isActive' => false]);

        $user = Auth::user();
        if ($user->role !== 'admin') {
            $user->update(['role' => 'membregenerale']);
        }

        return redirect()->route('colocations.index')->with('success', 'Colocation has been ended successfully.');
    }

    public function removeMember(Request $request, Colocation $colocation)
    {
        $owner = Auth::user();

        if (!$owner->ownsColocation($colocation)) {
            return redirect()->back()->with('error', 'Only the owner can remove members.');
        }

        $memberId = $request->input('user_id');

        // prevent owner from removing themselves
        if ($memberId == $owner->id) {
            return redirect()->back()->with('error', 'You cannot remove yourself. End the colocation instead.');
        }

        $member = User::findOrFail($memberId);

        // check if the member actually belongs to this colocation
        if (!$colocation->members()->where('user_id', $memberId)->exists()) {
            return redirect()->back()->with('error', 'This user is not a member of this colocation.');
        }

        // owner pays member's unpaid debts (mark them as paid)
        $unpaidDebtCount = Settlement::where('colocation_id', $colocation->id)
            ->where('payer_id', $memberId)
            ->where('payed', false)
            ->count();

        if ($unpaidDebtCount > 0) {
            Settlement::where('colocation_id', $colocation->id)
                ->where('payer_id', $memberId)
                ->where('payed', false)
                ->update(['payed' => true]);
        }

        // detach the member from the colocation
        $colocation->members()->detach($memberId);

        // downgrade their role
        if ($member->role !== 'admin') {
            $member->update(['role' => 'membregenerale']);
        }

        // decrement reputation 
        $member->decrement('reputation');

        // recalculate settlements now that a member left
        Settlement::recalculateForColocation($colocation->id);

        $msg = $unpaidDebtCount > 0
            ? "{$member->name} has been removed. Their {$unpaidDebtCount} unpaid debt(s) have been covered by you."
            : "{$member->name} has been removed from the colocation.";

        return redirect()->back()->with('success', $msg);
    }

    public function quitter(Request $request)
    {
        $user = Auth::user();

        // owners cannot leave colocation
        if ($user->ownsAnyColocation()) {
            return redirect()->back()->with('error', 'Owners cannot leave. You must end the colocation.');
        }

        $colocation = $user->active_colocation;

        if (!$colocation) {
            return redirect()->back()->with('error', 'You are not in an active colocation.');
        }

        // check for unpaid settlements
        $unpaid = Settlement::where('colocation_id', $colocation->id)
            ->where(function($q) use ($user) {
                $q->where('payer_id', $user->id)->orWhere('receiver_id', $user->id);
            })
            ->where('payed', false)
            ->exists();

        // reputation logic
        if ($unpaid) {
            $user->decrement('reputation');
        } else {
            $user->increment('reputation');
        }

        // detach member
        $colocation->members()->detach($user->id);

        if ($user->role !== 'admin') {
            $user->update(['role' => 'membregenerale']);
        }

        return redirect()->route('colocations.index')->with('success', 'You have left the colocation. Your reputation has been updated.');
    }
}

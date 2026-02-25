<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Colocation;
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
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'rules' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $colocation = Colocation::create($validated);
            
            $colocation->members()->attach(Auth::id(), [
                'type' => 'owner',
                'solde' => 0,
                'left_at' => now(), // Or null if migration allows
            ]);
        });

        return redirect()->route('colocations.index')->with('success', 'Colocation created successfully.');
    }

    public function show(Colocation $colocation)
    {
        $colocation->load('members');
        return view('colocations.show', compact('colocation'));
    }

    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    public function update(Request $request, Colocation $colocation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'rules' => 'required|string',
            'isActive' => 'boolean',
        ]);

        $colocation->update($validated);

        return redirect()->route('colocations.index')->with('success', 'Colocation updated successfully.');
    }

    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'Colocation deleted successfully.');
    }
}

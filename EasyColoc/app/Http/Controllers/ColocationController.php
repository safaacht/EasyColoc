<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;

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

    public function store(StoreColocationRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $colocation = Colocation::create($validated);
            
            $colocation->members()->attach(Auth::id(), [
                'type' => 'owner',
                'solde' => 0,
                
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

    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $validated = $request->validated();

        $colocation->update($validated);

        return redirect()->route('colocations.index')->with('success', 'Colocation updated successfully.');
    }

    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'Colocation deleted successfully.');
    }
}

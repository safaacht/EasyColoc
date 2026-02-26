<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Invitation;

class AdminController extends Controller
{
     public function dashboard()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_colocations' => Colocation::count(),
            'total_invitations' => Invitation::count(),
            'total_banned'      => User::where('is_banned', true)->count(),
            'owners'            => User::where('type', 'owner')->count(),
            'membres'           => User::where('type', 'membreGeneral')->count(),
        ];

        $users = User::latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'users'));
    }

    
    public function ban(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_banned'  => true
        ]);

        return back()->with('success', "User {$user->name} is banned.");
    }


    public function unban($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_banned'  => false,
        ]);

        return back()->with('success', "User {$user->name} is debanned.");
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function store(Request $request)
{
    //si la table est vide le premier sera admin
    $isFirstUser = User::count() == 0;

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $isFirstUser ? 'admin' : 'membregenerale',
    ]);

    return redirect()->route('login');
}


    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'colocation_id' => 'required|exists:colocation,id',
        ]);

        $colocation = Colocation::findOrFail($request->colocation_id);

        // sauf owners can send invitations
        if (!$request->user()->ownsColocation($colocation)) {
            return redirect()->back()->with('error', 'Only the owner can send invitations.');
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'User not found']);
        }

        if (!in_array($user->role, ['membregenerale', 'admin'])) {
            return redirect()->back()->with('error', 'Only general members or admins can be invited.');
        }

        //  if user is already a member of ANY colocation (joined)
        if ($user->memberships()->where('status', 'joined')->exists()) {
            return redirect()->back()->with('error', 'User is already a member of a colocation.');
        }

        $token = bin2hex(random_bytes(32));

        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $colocation->id,
            'token' => $token,
            'status' => 'pending',
            'type' => $user->role === 'admin' ? 'admin' : 'membre',
            'solde' => 0,
        ]);

        Mail::to($user->email)->send(new InvitationMail($token));

        return redirect()->back()->with('success', 'Invitation sent successfully.');
    }
    public function acceptInvitation($token)
    {
        $membership = Membership::where('token', $token)->firstOrFail();

        $user = $membership->user;

        // A member can only belong to one colocation at a time
        if ($user->memberships()->where('status', 'joined')->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'You are already a member of a colocation. Leave it first before joining another.');
        }

        $membership->update([
            'status' => 'joined',
            'token' => null,
        ]);

        if ($user->role !== 'admin') {
            $user->update(['role' => 'membre']);
        }

        return redirect()->route('dashboard')->with('success', 'You have joined the colocation!');
    }
}

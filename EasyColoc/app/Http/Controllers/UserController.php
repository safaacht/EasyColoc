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
        'role' => $isFirstUser ? 'admin' : 'membreGeneral',
    ]);

    return redirect()->route('login');
}


public function addMember(Request $request,Colocation $colocation)
{
    $email=$request->email;
    $user= User::where('email',$email)->first();

    if(!$user){
        return redirect()->back()
        ->withErrors(['name'=>'User not found']);
    }
// colocation activity
    $isActive=$user->colocations
                   ->where('colocations.isActive',1)
                   ->wherePivot('status','joined')
    ;


    $token=bin2hex(random_bytes(32));

    Membership::create([
        'user_id'         =>$user->id,
        'colocation_id'   =>$colocation->id ,
        'token'           =>$token,
        'status'        => 'pending'
    ]);

    Mail::to($user->email)->send(new InvitationMail($token));
}



}

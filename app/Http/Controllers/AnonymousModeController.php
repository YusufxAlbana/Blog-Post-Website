<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AnonymousModeController extends Controller
{
    public function toggle()
    {
        $currentUser = Auth::user();
        
        // Get the shared anonymous account
        $anonymousUser = User::where('email', 'anonymous@system.local')->first();
        
        if (!$anonymousUser) {
            return redirect()->back()->with('error', 'Anonymous account not found. Please contact administrator.');
        }
        
        // If currently using anonymous account, switch back to real account
        if ($currentUser->id === $anonymousUser->id) {
            $realUserId = Session::get('real_user_id');
            if ($realUserId) {
                $realUser = User::find($realUserId);
                if ($realUser) {
                    Auth::login($realUser);
                    Session::forget('real_user_id');
                    return redirect()->route('profile.show', $realUser)->with('success', 'Switched back to your real account');
                }
            }
            return redirect()->route('post.index')->with('error', 'Could not find your real account');
        }
        
        // Switch to anonymous account
        Session::put('real_user_id', $currentUser->id);
        Auth::login($anonymousUser);
        
        return redirect()->route('profile.show', $anonymousUser)->with('success', 'You are now in anonymous mode. Your identity is hidden.');
    }
}

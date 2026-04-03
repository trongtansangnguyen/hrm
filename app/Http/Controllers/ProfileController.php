<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile information.
     */
    public function show()
    {
        $user = Auth::user();
        $employee = $user->employee;

        return view('profile.show', compact('user', 'employee'));
    }
}

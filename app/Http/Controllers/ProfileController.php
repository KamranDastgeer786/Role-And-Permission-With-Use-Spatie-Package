<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    
    /**
     * Display the profile page.
     */
    public function show()
    {
        return view('auth.profile');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        session()->flash('alert', ['message' => 'Post successfully created', 'type' => 'success']);
        return redirect()->back();
    }

    /**
     * Save the user's theme preference.
     */
    public function saveTheme(Request $request)
    {
        // Handle theme saving logic
        dd($request->all()); // Remove or replace with actual logic
    }
}

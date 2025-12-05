<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();   // user yang sedang login
        return view('dashboard.mahasiswa.profil.profil', compact('user'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            switch ($user->role) {
                case 'admin':
                    return view('admin.dashboard');
                case 'guru':
                    return view('guru.dashboard');
                case 'siswa':
                    return view('siswa.dashboard');
                default:
                    return view('dashboard'); // Default dashboard for other roles or no role
            }
        }

        return redirect('/login'); // Redirect to login if no user is authenticated
    }
}

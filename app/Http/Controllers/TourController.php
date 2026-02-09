<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourController extends Controller
{
    public function complete(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->has_seen_tour = true;
            $user->save();
        }

        return response()->json(['status' => 'success']);
    }
}

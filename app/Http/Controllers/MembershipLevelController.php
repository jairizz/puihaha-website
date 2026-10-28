<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\Request;

class MembershipLevelController extends Controller
{
    public function index()
    {
        $levels = MembershipLevel::all();

        return view('levels.index', compact('levels'));
    }

    public function create()
    {
        return view('levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'fee' => 'required|numeric',
            'validity_period' => 'required|numeric',
        ]);

        MembershipLevel::create([
            'name' => $request->name,
            'fee' => $request->fee,
            'validity_period' => $request->validity_period,
            'benefits' => $request->benefits,
        ]);

        return redirect()->route('levels.index');
    }
}
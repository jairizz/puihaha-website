<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['category', 'level'])->get();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $categories = MembershipCategory::all();
        $levels = MembershipLevel::all();

        return view('members.create', compact(
            'categories',
            'levels'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'category_id' => 'required',
            'level_id' => 'required'
        ]);

        Member::create([
            'membership_no' => 'MEM-' . time(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'category_id' => $request->category_id,
            'level_id' => $request->level_id,
            'status' => 'active'
        ]);

        return redirect()->route('members.index');
    }
}
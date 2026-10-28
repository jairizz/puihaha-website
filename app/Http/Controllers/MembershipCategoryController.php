<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Http\Request;

class MembershipCategoryController extends Controller
{
    public function index()
    {
        $categories = MembershipCategory::all();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:membership_categories'
        ]);

        MembershipCategory::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('categories.index');
    }
}
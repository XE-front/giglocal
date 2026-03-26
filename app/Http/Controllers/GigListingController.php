<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\GigsCategory;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GigListingController extends Controller
{
    // Show the add gig form
    public function create()
    {
        $categories = GigsCategory::all(['id', 'name']);
        // You can also fetch barangays here if needed
        return Inertia::render('GigListing/AddGigPage', [
            'categories' => $categories,
            'barangays' => Barangay::select('id', 'barangay_name as name')->get(),
        ]);
    }

    // Store a new gig
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:gigs_categories,id',
            'description' => 'required|string',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per hour,per day,per project',
            'availability' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gigs', 'public');
        }

        Gig::create($validated);

        return redirect()->route('my-gigs')->with('success', 'Gig created successfully!');
    }
}

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
        $barangays = Barangay::all(['id', 'barangay_name as name']);
        // You can also fetch barangays here if needed
        return Inertia::render('GigListing/AddGigPage', [
            'categories' => $categories,
            'barangays' => $barangays,
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
            'post_status' => 'required|in:posted,archived,draft',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        // Always create new gigs as active
        $validated['status'] = 'active';

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gigs', 'public');
        }

        Gig::create($validated);

        return redirect()->route('my-gigs')->with('success', 'Gig created successfully!');
    }
    public function saveDraft(Request $request)
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
            'post_status' => 'required|in:posted,archived,draft',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active';
        $validated['post_status'] = 'draft';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gigs', 'public');
        }

        Gig::create($validated);

        return redirect()->route('my-gigs')->with('success', 'Gig saved as draft successfully!');
    }

    public function edit(Gig $gig)
    {
        $categories = GigsCategory::all(['id', 'name']);
        $barangays = Barangay::select('id', 'barangay_name as name')->get();

        return Inertia::render('GigListing/EditGigPage', [
            'categories' => $categories,
            'barangays'  => $barangays,
            'gig'        => [
                'id'          => $gig->id,
                'title'       => $gig->title,
                'category_id' => $gig->category_id,
                'description' => $gig->description,
                'street'      => $gig->street,
                'barangay'    => $gig->barangay,
                'price'       => $gig->price,
                'price_type'  => $gig->price_type,
                'availability'=> optional($gig->availability)->toDateString(),
                'post_status' => $gig->post_status,
                'status'      => $gig->status,
            ],
            'isDraftEdit' => $gig->post_status === 'draft',
        ]);
    }
    public function update(Request $request, Gig $gig)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:gigs_categories,id',
            'description' => 'required|string',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:per hour,per day,per project',
            'availability' => 'nullable|date',
            'post_status' => 'required|in:posted,archived,draft',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gigs', 'public');
        }

        $gig->update($validated);

        return redirect()->route('my-gigs')->with('success', 'Gig updated successfully!');
    }

    public function updateDraft(Request $request, Gig $gig)
    {
        // You can relax these rules if you want partial drafts
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:gigs_categories,id',
            'description' => 'nullable|string',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'nullable|in:per hour,per day,per project',
            'availability' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gigs', 'public');
        }

        // Keep it as a draft
        $validated['post_status'] = 'draft';

        $gig->update($validated);

        return redirect()->route('my-gigs.drafts')->with('success', 'Draft gig updated successfully!');
    }

    public function index()
    {
        $gigs = Gig::where('user_id', Auth::id())->with('category')
            ->where('post_status', '!=', 'draft')
            ->latest()
            ->get()
            ->map(function ($gig) {
                return [
                    'id' => $gig->id,
                    'title' => $gig->title,
                    'category' => $gig->category ? $gig->category->name : null,
                    'description' => $gig->description,
                    'street' => $gig->street,
                    'barangay' => $gig->barangay,
                    'price' => $gig->price,
                    'price_type' => $gig->price_type,
                    'availability' => $gig->availability ? $gig->availability->toDateString() : null,
                    'status' => $gig->status,
                    'image_url' => $gig->image ? asset('storage/' . $gig->image) : null,
                ];
            });
        return Inertia::render('GigListing/GigListing', [
            'gigs' => $gigs,
        ]);
    }

    public function drafts()
    {
        $gigs = Gig::where('user_id', Auth::id())->with('category')
            ->where('post_status', 'draft')
            ->latest()
            ->get()
            ->map(function ($gig) {
                return [
                    'id' => $gig->id,
                    'title' => $gig->title,
                    'category' => $gig->category ? $gig->category->name : null,
                    'description' => $gig->description,
                    'street' => $gig->street,
                    'barangay' => $gig->barangay,
                    'price' => $gig->price,
                    'price_type' => $gig->price_type,
                    'availability' => $gig->availability ? $gig->availability->toDateString() : null,
                    'status' => $gig->status,
                    'image_url' => $gig->image ? asset('storage/' . $gig->image) : null,
                    'updated_at' => $gig->updated_at->toDateTimeString(),
                ];
            });
        return Inertia::render('GigListing/GigDrafts', [
            'gigs' => $gigs,
        ]);
    }

}

<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\GigListingController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::inertia('browse-gigs', 'Browsing/BrowseGig')->name('browse-gigs');

    Route::inertia('booking-list', 'Booking/BookingList')->name('booking-list');

    Route::inertia('my-gigs', 'GigListing/GigListing')->name('my-gigs');
});

// Routes for add services/gigs
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('add-gig', [GigListingController::class, 'create'])->name('gigs.create');
    Route::post('gigs', [GigListingController::class, 'store'])->name('gigs.store');
});

require __DIR__.'/settings.php';

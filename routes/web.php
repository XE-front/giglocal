<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\GigListingController;
use App\Http\Controllers\ProfileController;
>>>>>>> Stashed changes

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
<<<<<<< Updated upstream
=======
    Route::inertia('browse-gigs', 'Browsing/BrowseGig')->name('browse-gigs');
    Route::inertia('booking-list', 'Booking/BookingList')->name('booking-list');

    Route::get('profile-page', [ProfileController::class, 'show'])->name('profile-page');
    Route::get('my-gigs', [GigListingController::class, 'index'])->name('my-gigs');
    Route::get('my-gigs/drafts', [GigListingController::class, 'drafts'])->name('my-gigs.drafts');
});

// Routes for CRUD services/gigs
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('add-gig', [GigListingController::class, 'create'])->name('gigs.create');
    Route::post('gigs', [GigListingController::class, 'store'])->name('gigs.store');
    Route::post('gigs/draft', [GigListingController::class, 'saveDraft'])->name('gigs.store.draft');
    Route::get('gigs/{gig}/edit', [GigListingController::class, 'edit'])->name('gigs.edit');
    Route::post('gigs/{gig}', [GigListingController::class, 'update'])->name('gigs.update');
    Route::post('gigs/{gig}/draft', [GigListingController::class, 'updateDraft'])->name('gigs.update.draft');
>>>>>>> Stashed changes
});

require __DIR__.'/settings.php';

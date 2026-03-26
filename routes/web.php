<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::inertia('browse-gigs', 'Browsing/BrowseGig')->name('browse-gigs');

    Route::inertia('booking-list', 'Booking/BookingList')->name('booking-list');

    Route::inertia('my-gigs', 'GigListing/GigListing')->name('my-gigs');
});

require __DIR__.'/settings.php';

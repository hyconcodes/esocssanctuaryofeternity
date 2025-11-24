<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/events', 'events')->name('events');
Route::view('/gallery', 'gallery')->name('gallery');
Route::view('/giving', 'giving')->name('giving');
Route::view('/audios', 'audios')->name('audios');
Route::view('/ministers', 'ministers')->name('ministers');
Route::view('/contact', 'contact')->name('contact');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Volt::route('admin/events', 'events.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.events');

Volt::route('admin/gallery', 'gallery.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.gallery');

Volt::route('admin/audios', 'audios.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.audios');

Volt::route('admin/testimonies', 'testimonies.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.testimonies');

Volt::route('admin/giving', 'giving.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.giving');

Route::get('/events/{slug}', function (string $slug) {
    $event = \App\Models\Event::where('slug', $slug)->firstOrFail();
    return view('event-read', compact('event'));
})->name('events.read');

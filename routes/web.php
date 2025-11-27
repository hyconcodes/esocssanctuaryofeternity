<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('/about', 'about')->name('about');
Route::view('/events', 'events')->name('events');
Route::view('/gallery', 'gallery')->name('gallery');
Route::view('/giving', 'giving')->name('giving');
Route::view('/audios', 'audios')->name('audios');
Route::view('/ministers', 'ministers')->name('ministers');
Route::view('/contact', 'contact')->name('contact');
Route::view('/membership', 'membership')->name('membership');

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

Volt::route('admin/contact', 'contact.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.contact');

Volt::route('admin/ministers', 'ministers.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.ministers');

Volt::route('admin/memberships', 'memberships.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.memberships');

Volt::route('admin/announcements', 'announcements.manage')
    ->middleware(['auth', 'admin'])
    ->name('admin.announcements');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);
    \App\Models\ContactMessage::create($data);
    return back()->with('message', 'Message sent');
})->name('contact.submit');

Route::get('/events/{slug}', function (string $slug) {
    $event = \App\Models\Event::where('slug', $slug)->firstOrFail();
    return view('event-read', compact('event'));
})->name('events.read');

Route::post('/testimonies/submit', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'nullable|string|max:255',
        'category' => 'nullable|string|in:healing,breakthrough,family-reconciliation',
        'rank' => 'nullable|string|max:64',
        'photo' => 'nullable|image|max:4096',
        'gender' => 'nullable|string|max:32',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:32',
        'country' => 'nullable|string|max:64',
        'message' => 'required|string',
    ]);

    $payload = [
        'title' => $data['title'] ? $data['title'] : ('Testimony from '.$data['name']),
        'author' => $data['name'],
        'description' => $data['message'],
        'category' => $data['category'] ?? null,
        'rank' => $data['rank'] ?? null,
        'gender' => $data['gender'] ?? null,
        'email' => $data['email'] ?? null,
        'phone' => $data['phone'] ?? null,
        'country' => $data['country'] ?? null,
        'is_featured' => false,
    ];
    if (!empty($data['photo']) && $request->file('photo')) {
        $path = $request->file('photo')->store('testimonies', 'public');
        $payload['author_photo_path'] = $path;
    }
    \App\Models\Testimony::create($payload);
    return back()->with('message', 'Thank you for sharing your testimony!');
})->name('testimonies.submit');

Route::post('/membership/submit', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'email' => 'required|email|max:255',
        'name' => 'required|string|max:255',
        'priesthood_office' => 'required|string|max:255',
        'phone1' => 'required|string|max:64',
        'phone2' => 'nullable|string|max:64',
        'relation_or_caregiver' => 'nullable|string',
        'dob' => 'required|date',
        'address' => 'required|string',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'occupation' => 'required|string|in:teacher,doctor,engineer,nurse,civil-servant,self-employed,other',
        'occupation_other' => 'nullable|string|max:255',
        'relationship_status' => 'required|string|in:single,married',
        'spouse_name' => 'nullable|string|max:255',
        'children_count' => 'nullable|integer|min:0|max:6',
        'membership_year' => 'required|string|max:4',
        'membership_id' => 'required|string|max:64',
        'faith_grad_date' => 'nullable|date',
        'faith_department' => 'nullable|string|max:255',
    ]);
    if ($data['occupation'] !== 'other') {
        $data['occupation_other'] = null;
    }
    if ($data['relationship_status'] !== 'married') {
        $data['spouse_name'] = null;
        $data['children_count'] = null;
    }
    \App\Models\Membership::create($data);
    return back()->with('message', 'Membership submitted successfully');
})->name('membership.submit');

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
        ['loc' => route('events'), 'changefreq' => 'daily', 'priority' => '0.9'],
        ['loc' => route('gallery'), 'changefreq' => 'weekly', 'priority' => '0.7'],
        ['loc' => route('audios'), 'changefreq' => 'weekly', 'priority' => '0.6'],
        ['loc' => route('giving'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => route('ministers'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => route('membership'), 'changefreq' => 'monthly', 'priority' => '0.5'],
    ];
    if (\Illuminate\Support\Facades\Schema::hasTable('events')) {
        $events = \App\Models\Event::orderBy('updated_at','desc')->take(30)->get();
        foreach ($events as $e) {
            $urls[] = [
                'loc' => route('events.read', $e->slug),
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'lastmod' => optional($e->updated_at)->toAtomString(),
            ];
        }
    }
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $u) {
        $xml .= '<url>';
        $xml .= '<loc>'.htmlspecialchars($u['loc'], ENT_XML1).'</loc>';
        $xml .= '<lastmod>'.htmlspecialchars(($u['lastmod'] ?? now()->toAtomString()), ENT_XML1).'</lastmod>';
        $xml .= '<changefreq>'.$u['changefreq'].'</changefreq>';
        $xml .= '<priority>'.$u['priority'].'</priority>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type','application/xml');
});

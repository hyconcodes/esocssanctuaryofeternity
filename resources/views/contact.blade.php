@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">Contact Us</h1>
            <div class="mt-6 grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    @php
                        $setting = \App\Models\ContactSetting::query()->orderBy('created_at','desc')->first();
                    @endphp
                    @if (session('message'))
                        <div class="mb-3 rounded-sm bg-green-100 text-green-700 p-3">{{ session('message') }}</div>
                    @endif
                    <form method="POST" action="{{ route('contact.submit') }}" class="grid gap-3">
                        @csrf
                        <input type="text" name="name" placeholder="Your name" class="rounded-sm border p-3" />
                        <input type="email" name="email" placeholder="Email" class="rounded-sm border p-3" />
                        <input type="text" name="phone" placeholder="Phone" class="rounded-sm border p-3" />
                        <textarea name="message" placeholder="Message" rows="5" class="rounded-sm border p-3"></textarea>
                        <button class="rounded-sm bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Send Message</button>
                    </form>
                </div>
                <div class="grid gap-4">
                    <div class="rounded-sm p-4 border bg-white shadow-md shadow-purple-200">
                        <div class="font-semibold text-[#45016a]">Address</div>
                        <p class="text-neutral-700">{{ $setting->address ?? '54, Ikwere Road, Adjacent Rumuokuta Flyover Bridge, Rumuokuta Port Harcourt.' }}</p>
                    </div>
                    <div class="rounded-sm p-4 border bg-white shadow-md shadow-purple-200">
                        <div class="font-semibold text-[#45016a]">Phone</div>
                        <p class="text-neutral-700">{{ $setting->phone ?? '+234-8138703124' }}</p>
                    </div>
                    <div class="rounded-sm p-4 border bg-white shadow-md shadow-purple-200">
                        <div class="font-semibold text-[#45016a]">Email</div>
                        <p class="text-neutral-700">{{ $setting->email ?? 'sanctuaryofeternityhop@gmail.com' }}</p>
                    </div>
                    <div class="rounded-sm overflow-hidden border bg-white shadow-md shadow-purple-200">
                        @php
                            $map = $setting && $setting->map_embed_url ? $setting->map_embed_url : 'https://www.google.com/maps?q='.urlencode('54, Ikwere Road, Adjacent Rumuokuta Flyover Bridge, Rumuokuta Port Harcourt.').'&output=embed';
                        @endphp
                        <iframe class="w-full h-40" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="{{ $map }}"></iframe>
                    </div>
                    <div class="rounded-sm p-4 border bg-white shadow-md shadow-purple-200">
                        <div class="font-semibold text-[#45016a]">Service Times</div>
                        <p class="text-neutral-700">Sun: 8:00am & 10:00am</p>
                        <p class="text-neutral-700">Wed: 5:00pm (Bible Study)</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="#" class="rounded-sm p-2 border hover:bg-[#ffc0cb]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-[#45016a]"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96s9.96-4.46 9.96-9.96c0-5.5-4.46-9.96-9.96-9.96Zm1.19 14.82h-2.25V10.5h2.25v6.36Zm-.06-7.65h-2.22V7.02h2.22v2.19Z"/></svg>
                        </a>
                        <a href="#" class="rounded-sm p-2 border hover:bg-[#ffc0cb]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-[#45016a]"><path d="M12 2.04C6.5 2.04 2.04 6.5 2.04 12s4.46 9.96 9.96 9.96 9.96-4.46 9.96-9.96S17.5 2.04 12 2.04Zm3.76 7.12h-1.85c-1.45 0-1.73.69-1.73 1.7v1.42h3.37l-.44 3.42h-2.93v8.76H8.81v-8.76H7V12.28h1.81v-1.54c0-1.79.98-4.53 4.53-4.53l2.42.02v3.93Z"/></svg>
                        </a>
                        <a href="#" class="rounded-sm p-2 border hover:bg[#ffc0cb]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-[#45016a]"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96s9.96-4.46 9.96-9.96c0-5.5-4.46-9.96-9.96-9.96Zm3.7 13.1c-1.89 0-3.42-1.53-3.42-3.42s1.53-3.42 3.42-3.42 3.42 1.53 3.42 3.42-1.53 3.42-3.42 3.42Zm0-5.22a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6ZM7.21 7.21h3.6v3.6h-3.6v-3.6Z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

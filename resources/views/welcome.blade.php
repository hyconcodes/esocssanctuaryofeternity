@extends('layouts.site')

@section('content')
    <section class="relative" data-animate>
        <div class="relative h-[70vh] lg:h-[75vh] w-full overflow-hidden shadow-md shadow-purple-200">
            <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline>
                <source src="{{ asset("assets/intro.mp4") }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-[#45016a]/30"></div>
            <div class="relative z-10 flex h-full items-center px-6 lg:px-10">
                <div class="max-w-2xl text-white">
                    <h1 class="text-3xl lg:text-5xl font-bold">Welcome to ESOCS Platinum Branch</h1>
                    <p class="mt-4 text-white/90">Raising a holy, loving, and faithful people committed to Christ, community, and service.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="rounded-sm bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Join Us</a>
                        <a href="#" class="rounded-sm bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="grid lg:grid-cols-2 gap-6 items-center">
            <div class="rounded-sm overflow-hidden shadow-md shadow-purple-200">
                <img src="{{ asset("assets/whoweare.jpg") }}" alt="Congregation" class="w-full h-[320px] object-cover" />
            </div>
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h2 class="text-2xl font-semibold text-[#45016a]">Who We Are</h2>
                <p class="mt-3 text-neutral-700">We are a Christ-centered community proclaiming the gospel and discipling believers to live in love, faith, holiness, respect, diligence, and service.</p>
                <div class="mt-6 grid lg:grid-cols-2 gap-6">
                    <div class="rounded-sm p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200">
                        <div class="text-xl font-semibold text-[#45016a]">Vision Statement</div>
                        <p class="mt-2 text-neutral-700">To build a sanctuary where lives encounter Jesus, families flourish, and generations follow God wholeheartedly.</p>
                    </div>
                    <div class="rounded-sm p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200">
                        <div class="text-xl font-semibold text-[#45016a]">Mission Statement</div>
                        <p class="mt-2 text-neutral-700">To preach Christ, nurture believers, and serve our city through intentional outreach and compassionate ministry.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="grid lg:grid-cols-2 gap-6 items-center">
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h2 class="text-2xl font-semibold text-[#45016a]">Core Values</h2>
                <div class="mt-4 grid sm:grid-cols-2 gap-3">
                    @foreach(['Love','Unshakable Faith','Holiness','Respect','Diligence','Service'] as $value)
                        <div class="rounded-sm border border-[#ffc0cb] p-4 text-center bg-white shadow-md shadow-purple-200">{{ $value }}</div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-sm overflow-hidden shadow-md shadow-purple-200">
                <img src="{{ asset("assets/corevalue.jpg") }}" alt="Worship" class="w-full h-[320px] object-cover" />
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        @php
            $event = \App\Models\Event::query()->orderBy('is_featured','desc')->orderBy('starts_at','asc')->first();
        @endphp
        <div class="mb-4">
            <h2 class="text-2xl font-semibold text-[#45016a]">Featured Event</h2>
        </div>
        <div class="rounded-sm overflow-hidden shadow-md shadow-purple-200">
            @if($event)
                <div class="grid lg:grid-cols-2">
                    <div class="relative h-56 lg:h-full">
                        @if($event->flyer_path)
                            <img src="{{ asset('storage/'.$event->flyer_path) }}" alt="Flyer" class="absolute inset-0 w-full h-full object-cover" />
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-[#45016a] to-[#ffc0cb]"></div>
                        @endif
                        <div class="absolute inset-0 bg-black/20"></div>
                    </div>
                    <div class="p-6 bg-[#45016a] text-white">
                        <h2 class="text-3xl font-bold truncate">{{ $event->title }}</h2>
                        <p class="mt-2 text-white/90">{{ \Illuminate\Support\Str::limit($event->description, 160) }}</p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 rounded-sm bg-white/10 px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M6.75 3A1.75 1.75 0 0 0 5 4.75v.5h14v-.5A1.75 1.75 0 0 0 17.25 3h-10.5ZM19 7.25H5V18a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V7.25ZM9.75 12a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-3Z"/></svg>
                                <span class="text-sm">{{ optional($event->starts_at)->format('D, M j · g:i A') }}</span>
                            </div>
                            <div class="flex items-center gap-2 rounded-sm bg-white/10 px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 2.25a7.5 7.5 0 0 0-7.5 7.5c0 4.518 4.337 9.533 6.328 11.52a1.67 1.67 0 0 0 2.344 0C15.163 19.283 19.5 14.268 19.5 9.75a7.5 7.5 0 0 0-7.5-7.5Zm0 10.125a2.625 2.625 0 1 1 0-5.25 2.625 2.625 0 0 1 0 5.25Z" clip-rule="evenodd"/></svg>
                                <span class="text-sm">{{ $event->venue }}</span>
                            </div>
                            <div class="flex items-center gap-2 rounded-sm bg-white/10 px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M4.5 7.5A3 3 0 0 1 7.5 4.5h9a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9Zm4.5 1.5h6v1.5h-6V9Z"/></svg>
                                <span class="text-sm">{{ $event->category }}</span>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('events.read', $event->slug) }}" class="rounded-sm px-4 py-2 bg-white text-[#45016a] hover:bg-[#ffc0cb] transition">Read more</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6 bg-[#45016a] text-white">
                    <div class="text-center">
                        <div class="text-2xl font-semibold">No upcoming events</div>
                        <div class="text-white/80">Stay tuned for updates.</div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Gallery</h2>
            </div>
            <div class="mt-4 flex items-center justify-end gap-2">
                <button type="button" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb]" onclick="document.getElementById('homeGallerySlider').scrollBy({left: -320, behavior: 'smooth'})">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M15.53 4.47a.75.75 0 0 1 0 1.06L9.56 11.5l5.97 5.97a.75.75 0 1 1-1.06 1.06l-6.5-6.5a.75.75 0 0 1 0-1.06l6.5-6.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                </button>
                <button type="button" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb]" onclick="document.getElementById('homeGallerySlider').scrollBy({left: 320, behavior: 'smooth'})">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M8.47 4.47a.75.75 0 0 1 1.06 0l6.5 6.5a.75.75 0 0 1 0 1.06l-6.5 6.5a.75.75 0 1 1-1.06-1.06l5.97-5.97-5.97-5.97a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </button>
            </div>
            <div id="homeGallerySlider" class="mt-4 flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory">
                @php
                    $images = \App\Models\GalleryImage::orderBy('is_featured','desc')->orderBy('created_at','desc')->take(12)->get();
                @endphp
                @forelse($images as $img)
                    <div class="relative flex-none w-72 h-56 rounded-sm overflow-hidden snap-start" data-category="{{ $img->category ?? '' }}">
                        <a href="{{ asset('storage/'.$img->image_path) }}" class="glightbox absolute inset-0 block" data-gallery="homeGallery" @if($img->title) data-title="{{ $img->title }}" @endif @if($img->description) data-description="{{ $img->description }}" @endif>
                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="Gallery" class="h-full w-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            @if($img->category)
                                <span class="absolute top-2 left-2 z-10 px-2 py-1 text-xs rounded-full bg-white/20 text-white backdrop-blur">{{ ucfirst($img->category) }}</span>
                            @endif
                            @if($img->title || $img->description)
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                                    @if($img->title)
                                        <div class="text-sm font-semibold truncate">{{ $img->title }}</div>
                                    @endif
                                    @if($img->description)
                                        <div class="text-xs text-white/90 line-clamp-2">{{ \Illuminate\Support\Str::limit($img->description, 80) }}</div>
                                    @endif
                                </div>
                            @endif
                        </a>
                    </div>
                @empty
                    <div class="text-center py-8 text-neutral-600">No gallery images yet.</div>
                @endforelse
            </div>
            <div class="mt-4 flex flex-wrap gap-2" id="homeGalleryCats">
                <button type="button" data-filter="all" data-target="#homeGallerySlider" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb] bg-[#ffc0cb] border-[#ffc0cb]">All</button>
                @php $cats = ['Programs','Choir','Youth','Outreach']; @endphp
                @foreach($cats as $f)
                    @php $slug = strtolower($f); @endphp
                    <button type="button" data-filter="{{ $slug }}" data-target="#homeGallerySlider" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">
                        {{ $f }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Audios</h2>
            </div>
            @php
                $latestAudio = \App\Models\Audio::orderBy('is_featured','desc')->first();
            @endphp
            @if($latestAudio)
                <div class="mt-6 rounded-sm p-5 bg-white border shadow-md shadow-purple-200">
                    <div class="flex items-start gap-4">
                        <button class="rounded-sm bg-[#45016a] text-white p-4 hover:bg-[#ffc0cb] hover:text-[#45016a] transition" onclick="this.closest('.rounded-sm').querySelector('audio')?.play()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7"><path d="M8 5.5v13l11-6.5-11-6.5Z" /></svg>
                        </button>
                        <div class="flex-1">
                            <div class="text-xl font-semibold text-[#45016a]">{{ $latestAudio->title }}</div>
                            <div class="text-sm text-neutral-600">{{ ucwords(str_replace('-', ' ', $latestAudio->category ?? '')) }}</div>
                            @if($latestAudio->description)
                                <p class="mt-2 text-neutral-700">{{ \Illuminate\Support\Str::limit($latestAudio->description, 160) }}</p>
                            @endif
                            @if($latestAudio->audio_path)
                                <audio controls class="mt-4 w-full">
                                    <source src="{{ asset('storage/'.$latestAudio->audio_path) }}" />
                                </audio>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 text-center py-8 text-neutral-600">No audios yet.</div>
            @endif
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Testimonies</h2>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb]" data-action="prev">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M15.53 4.47a.75.75 0 0 1 0 1.06L9.56 11.5l5.97 5.97a.75.75 0 1 1-1.06 1.06l-6.5-6.5a.75.75 0 0 1 0-1.06l6.5-6.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                    </button>
                    <button type="button" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb]" data-action="next">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M8.47 4.47a.75.75 0 0 1 1.06 0l6.5 6.5a.75.75 0 0 1 0 1.06l-6.5 6.5a.75.75 0 1 1-1.06-1.06l5.97-5.97-5.97-5.97a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            </div>
            <div id="homeTestimoniesCarousel" class="mt-4 relative min-h-[260px]" data-carousel data-autoplay data-interval="4000">
                @php
                    $testimonies = \App\Models\Testimony::orderBy('is_featured','desc')->orderBy('created_at','desc')->take(12)->get();
                @endphp
                @forelse($testimonies as $idx => $t)
                    <div class="transition duration-500 ease-in-out @if($idx === 0) opacity-100 relative @else opacity-0 absolute inset-0 pointer-events-none @endif" data-carousel-item data-index="{{ $idx }}">
                        <div class="rounded-2xl border border-[#ffc0cb] p-6 bg-white shadow-md shadow-purple-200 max-w-2xl mx-auto">
                            <div class="flex flex-col items-center text-center gap-3">
                                @php
                                    $photo = $t->author_photo_path ? asset('storage/'.$t->author_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($t->author ?? 'Member').'&background=ffc0cb&color=45016a';
                                @endphp
                                <img src="{{ $photo }}" alt="Author" class="h-16 w-16 rounded-full object-cover border" />
                                <div class="text-lg font-semibold text-[#45016a]">{{ $t->title }}</div>
                                <div class="text-xs text-neutral-600">{{ ucwords(str_replace('-', ' ', $t->category ?? '')) }}</div>
                                @if($t->description)
                                    <blockquote class="mt-1 text-neutral-800 italic text-lg">“{{ $t->description }}”</blockquote>
                                @endif
                                @if($t->author)
                                    <div class="text-sm text-neutral-700">— {{ $t->author }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-neutral-600">No testimonies yet.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-2xl font-semibold text-[#45016a]">Offerings & Donation</h2>
            <p class="mt-2 text-neutral-700 italic">“God loves a cheerful giver…” — 2 Corinthians 9:7</p>
            <p class="mt-2 text-neutral-700 italic">Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver. Consider sharing a donation to support a good cause.</p>
            @php
                $giving = \App\Models\Giving::orderBy('is_featured','desc')->orderBy('created_at','desc')->first();
            @endphp
            <div class="mt-6 rounded-sm border border-[#ffc0cb] p-5 bg-white shadow-md shadow-purple-200 text-center">
                <div class="font-semibold text-[#45016a]">Bank Transfer</div>
                @if($giving)
                    <div class="mt-2 text-neutral-700">
                        <div class="text-lg font-semibold">{{ $giving->account_number }}</div>
                        <div>{{ $giving->account_name }}</div>
                        <div>{{ $giving->bank_name }}</div>
                    </div>
                @else
                    <p class="mt-2 text-neutral-700">No account info yet.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 mb-16" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="grid lg:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2xl font-semibold text-[#45016a]">Contact Us</h2>
                    <p class="mt-2 text-neutral-700">Address: 123 Sanctuary Road, Port Harcourt, Rivers State</p>
                    <p class="text-neutral-700">Phone: +234 800 000 0000</p>
                    <p class="text-neutral-700">Email: info@esocsplatinum.org</p>
                    <div class="mt-4">
                        <form method="POST" action="#" class="grid gap-3">
                            @csrf
                            <input type="text" name="name" placeholder="Your name" class="rounded-sm border p-3" />
                            <input type="email" name="email" placeholder="Email" class="rounded-sm border p-3" />
                            <textarea name="message" placeholder="Message" rows="4" class="rounded-sm border p-3"></textarea>
                            <button class="rounded-sm bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Send Message</button>
                        </form>
                    </div>
                </div>
                <div>
                    <iframe class="rounded-sm w-full h-[300px] lg:h-full shadow-md shadow-purple-200" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3939.8000000000006!2d7.000000!3d4.800000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1069d00000000000%3AESOCS%20Platinum%20Branch!5e0!3m2!1sen!2sng!4v1700000000000"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.site')

@section('content')
    <section class="relative" data-animate>
        <div class="relative h-[70vh] lg:h-[75vh] w-full overflow-hidden shadow-md shadow-purple-200">
            <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline>
                <source src="{{ asset("assets/intro.mp4") }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-[#45016a]/60"></div>
            <div class="relative z-10 flex h-full items-center px-6 lg:px-10">
                <div class="max-w-2xl text-white">
                    <h1 class="text-3xl lg:text-5xl font-bold">Welcome to ESOCS Platinum Branch</h1>
                    <p class="mt-4 text-white/90">Raising a holy, loving, and faithful people committed to Christ, community, and service.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="#" class="rounded-2xl bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Join Us</a>
                        <a href="#" class="rounded-2xl bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 grid gap-8" data-animate>
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
                <h2 class="text-2xl font-semibold text-[#45016a]">Who We Are</h2>
                <p class="mt-3 text-neutral-700">We are a Christ-centered community proclaiming the gospel and discipling believers to live in love, faith, holiness, respect, diligence, and service.</p>
                <div class="mt-6 grid lg:grid-cols-2 gap-6">
                    <div class="rounded-2xl p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200">
                        <h3 class="text-xl font-semibold text-[#45016a]">Vision Statement</h3>
                        <p class="mt-2 text-neutral-700">To build a sanctuary where lives encounter Jesus, families flourish, and generations follow God wholeheartedly.</p>
                    </div>
                    <div class="rounded-2xl p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200">
                        <h3 class="text-xl font-semibold text-[#45016a]">Mission Statement</h3>
                        <p class="mt-2 text-neutral-700">To preach Christ, nurture believers, and serve our city through intentional outreach and compassionate ministry.</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
                <h3 class="text-xl font-semibold text-[#45016a]">Core Values</h3>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    @foreach(['Love','Faith','Holiness','Respect','Diligence','Service'] as $value)
                        <div class="rounded-2xl border border-[#ffc0cb] p-4 text-center bg-white shadow-md shadow-purple-200">{{ $value }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-[#45016a] text-white shadow-md shadow-purple-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-semibold">Centenary Special Holy Communion</h2>
                    <p class="mt-2 text-white/90">Join us for a sacred time of worship and communion as we celebrate God's faithfulness through the years.</p>
                </div>
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="rounded-2xl bg-white/10 p-4">
                        <div class="text-sm">Date & Time</div>
                        <div class="font-semibold">Sun, Dec 15 · 5:00 PM</div>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <div class="text-sm">Venue</div>
                        <div class="font-semibold">ESOCS Platinum Branch Auditorium</div>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <div class="text-sm">Description</div>
                        <div class="font-semibold">A solemn evening service and thanksgiving.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Gallery</h2>
                <div class="flex gap-2">
                    @foreach(['Programs','Choir','Youth','Outreach'] as $f)
                        <button class="rounded-2xl border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]" data-filter="{{ strtolower($f) }}">{{ $f }}</button>
                    @endforeach
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $images = [
                        ['url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1200&auto=format&fit=crop', 'cat' => 'programs'],
                        ['url' => 'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?q=80&w=1200&auto=format&fit=crop', 'cat' => 'choir'],
                        ['url' => 'https://images.unsplash.com/photo-1453728013993-6db114c45e05?q=80&w=1200&auto=format&fit=crop', 'cat' => 'youth'],
                        ['url' => 'https://images.unsplash.com/photo-1526948128573-703ee1aeb6fa?q=80&w=1200&auto=format&fit=crop', 'cat' => 'outreach'],
                        ['url' => 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=1200&auto=format&fit=crop', 'cat' => 'programs'],
                        ['url' => 'https://images.unsplash.com/photo-1496307653780-42ee777d4833?q=80&w=1200&auto=format&fit=crop', 'cat' => 'choir'],
                    ];
                @endphp
                @foreach($images as $img)
                    <div class="group relative overflow-hidden rounded-2xl" data-category="{{ $img['cat'] }}">
                        <img src="{{ $img['url'] }}" alt="Gallery" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105" data-lightbox="{{ $img['url'] }}" />
                        <div class="absolute inset-0 bg-[#ffc0cb]/0 group-hover:bg-[#ffc0cb]/25 transition"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Audios</h2>
                <a href="#" class="rounded-2xl bg-[#45016a] text-white px-5 py-2 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Listen to sermons</a>
            </div>
            <div class="mt-4 flex items-center gap-2 text-[#45016a]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M4 10h2v4H4zm4-6h2v16H8zm4 4h2v8h-2zm4-2h2v12h-2z" />
                </svg>
                <span class="text-neutral-700">Sermon archive available via our cloud drive</span>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#45016a]">Testimonies</h2>
                <a href="#" class="rounded-2xl border px-4 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb] transition">View more</a>
            </div>
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['title' => 'Healed from illness', 'text' => 'God restored my health after months of prayer.'],
                    ['title' => 'Breakthrough at work', 'text' => 'Received a promotion after trusting God.'],
                    ['title' => 'Family reconciliation', 'text' => 'The Lord healed our home and relationships.'],
                ] as $t)
                    <div class="rounded-2xl border border-[#ffc0cb] p-5 bg-white shadow-md shadow-purple-200">
                        <div class="font-semibold text-[#45016a]">{{ $t['title'] }}</div>
                        <p class="mt-2 text-neutral-700">{{ $t['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-2xl font-semibold text-[#45016a]">Giving / Donation</h2>
            <p class="mt-2 text-neutral-700 italic">“God loves a cheerful giver…” — 2 Corinthians 9:7</p>
            <div class="mt-6 grid lg:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-[#ffc0cb] p-5 bg-white shadow-md shadow-purple-200">
                    <div class="font-semibold text-[#45016a]">Bank Transfer</div>
                    <p class="mt-2 text-neutral-700">Sterling Bank · ESOCS Platinum Branch</p>
                    <p class="text-neutral-700">Acct Name: ESOCS Platinum Branch</p>
                    <p class="text-neutral-700">Acct No: 0000000000</p>
                </div>
                <div class="rounded-2xl border border-[#ffc0cb] p-5 bg-white shadow-md shadow-purple-200">
                    <div class="font-semibold text-[#45016a]">Giving Frequency</div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach(['One-time','Weekly','Monthly','Quarterly'] as $f)
                            <button class="rounded-2xl border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">{{ $f }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-2xl p-5 bg-[#ffc0cb] text-[#45016a] shadow-md shadow-purple-200">
                    <div class="font-semibold">Give Online</div>
                    <p class="mt-2">Use your card to give securely.</p>
                    <div class="mt-4 flex gap-3">
                        <a href="#" class="rounded-2xl bg-[#45016a] text-white px-4 py-2 hover:bg-[#45016a]/90">Give via Card</a>
                        <a href="#" class="rounded-2xl bg-white text-[#45016a] px-4 py-2 hover:bg:white/90">Give via Transfer</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 mb-16" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="grid lg:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2xl font-semibold text-[#45016a]">Contact Us</h2>
                    <p class="mt-2 text-neutral-700">Address: 123 Sanctuary Road, Port Harcourt, Rivers State</p>
                    <p class="text-neutral-700">Phone: +234 800 000 0000</p>
                    <p class="text-neutral-700">Email: info@esocsplatinum.org</p>
                    <div class="mt-4">
                        <form method="POST" action="#" class="grid gap-3">
                            @csrf
                            <input type="text" name="name" placeholder="Your name" class="rounded-2xl border p-3" />
                            <input type="email" name="email" placeholder="Email" class="rounded-2xl border p-3" />
                            <textarea name="message" placeholder="Message" rows="4" class="rounded-2xl border p-3"></textarea>
                            <button class="rounded-2xl bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Send Message</button>
                        </form>
                    </div>
                </div>
                <div>
                    <iframe class="rounded-2xl w-full h-[300px] lg:h-full shadow-md shadow-purple-200" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3939.8000000000006!2d7.000000!3d4.800000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1069d00000000000%3AESOCS%20Platinum%20Branch!5e0!3m2!1sen!2sng!4v1700000000000"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection


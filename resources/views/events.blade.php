@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">Upcoming Events</h1>
            <div class="mt-6 relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-[#ffc0cb]"></div>
                <div class="grid gap-6">
                    @foreach([
                        ['title' => 'Centenary Special Holy Communion', 'date' => 'Sun, Dec 15 · 5:00 PM', 'desc' => 'A sacred time of worship and thanksgiving.', 'img' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1200&auto=format&fit=crop'],
                        ['title' => 'Christmas Carol Service', 'date' => 'Sun, Dec 22 · 6:00 PM', 'desc' => 'Choir-led carols and scripture readings.', 'img' => 'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?q=80&w=1200&auto=format&fit=crop'],
                    ] as $e)
                        <div class="relative ms-10">
                            <div class="absolute -left-6 top-2 size-3 rounded-full bg-[#45016a]"></div>
                            <div class="rounded-2xl p-4 bg-white border shadow-md shadow-purple-200">
                                <div class="grid lg:grid-cols-3 gap-4">
                                    <img src="{{ $e['img'] }}" alt="Event" class="rounded-2xl w-full h-40 object-cover">
                                    <div class="lg:col-span-2">
                                        <div class="text-[#45016a] font-semibold">{{ $e['title'] }}</div>
                                        <div class="text-sm text-neutral-600">{{ $e['date'] }}</div>
                                        <p class="mt-2 text-neutral-700">{{ $e['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-2xl font-semibold text-[#45016a]">Past Events</h2>
            <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(range(1,6) as $i)
                    <div class="rounded-2xl border p-4 bg-white shadow-md shadow-purple-200">
                        <img src="https://images.unsplash.com/photo-1453728013993-6db114c45e05?q=80&w=1200&auto=format&fit=crop" class="rounded-2xl h-32 w-full object-cover" alt="Past Event">
                        <div class="mt-3 font-semibold text-[#45016a]">Outreach {{ $i }}</div>
                        <p class="text-sm text-neutral-700">A snapshot from our previous programs and gatherings.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection


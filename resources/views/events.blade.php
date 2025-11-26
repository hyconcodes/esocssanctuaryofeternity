@extends('layouts.site')
@section('title','Events — ESOCS Platinum Branch')
@section('meta_description','Upcoming and past events at ESOCS Sanctuary of Eternity in Port Harcourt.')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        @php
            $now = \Carbon\Carbon::now();
            $upcoming = \App\Models\Event::where(function($q) use ($now) {
                    $q->whereNotNull('ends_at')->where('ends_at','>=',$now);
                })
                ->orWhere(function($q) use ($now) {
                    $q->whereNull('ends_at')->where('starts_at','>=',$now);
                })
                ->orderBy('starts_at','asc')
                ->get();
        @endphp
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">Upcoming Events</h1>
            <div class="mt-6 relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-[#ffc0cb]"></div>
                <div class="grid gap-6">
                    @forelse($upcoming as $e)
                        <div class="relative ms-10">
                            <div class="absolute -left-6 top-2 size-3 rounded-full bg-[#45016a]"></div>
                            <div class="rounded-sm p-4 bg-white border shadow-md shadow-purple-200">
                                <div class="grid lg:grid-cols-3 gap-4">
                                    @if($e->flyer_path)
                                        <img src="{{ asset('storage/'.$e->flyer_path) }}" alt="Event" class="rounded-sm w-full h-40 object-cover">
                                    @endif
                                    <div class="lg:col-span-2">
                                        <div class="text-[#45016a] font-semibold">{{ $e->title }}</div>
                                        <div class="text-sm text-neutral-600">{{ optional($e->starts_at)->format('D, M j · g:i A') }}@if($e->venue) · {{ $e->venue }}@endif</div>
                                        <p class="mt-2 text-neutral-700">{{ \Illuminate\Support\Str::limit($e->description, 160) }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('events.read', $e->slug) }}" class="rounded-sm px-3 py-2 border hover:bg-[#ffc0cb]">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-neutral-600">No events available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10" data-animate>
        @php
            $past = \App\Models\Event::where(function($q) use ($now) {
                    $q->whereNotNull('ends_at')->where('ends_at','<',$now);
                })
                ->orWhere(function($q) use ($now) {
                    $q->whereNull('ends_at')->where('starts_at','<',$now);
                })
                ->orderBy('ends_at','desc')
                ->orderBy('starts_at','desc')
                ->get();
        @endphp
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-2xl font-semibold text-[#45016a]">Past Events</h2>
            <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($past as $e)
                    <div class="rounded-sm border p-4 bg-white shadow-md shadow-purple-200">
                        @if($e->flyer_path)
                            <img src="{{ asset('storage/'.$e->flyer_path) }}" class="rounded-sm h-32 w-full object-cover" alt="Past Event">
                        @endif
                        <div class="mt-3 font-semibold text-[#45016a]">{{ $e->title }}</div>
                        <div class="text-sm text-neutral-600">{{ optional($e->ends_at ?? $e->starts_at)->format('D, M j · g:i A') }}</div>
                        <p class="text-sm text-neutral-700 mt-1">{{ \Illuminate\Support\Str::limit($e->description, 120) }}</p>
                        <div class="mt-2">
                            <a href="{{ route('events.read', $e->slug) }}" class="rounded-sm px-3 py-2 border hover:bg-[#ffc0cb]">Read more</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-neutral-600">No past events.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

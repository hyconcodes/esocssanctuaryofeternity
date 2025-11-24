@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10 mt-6" data-animate>
        <div class="rounded-sm overflow-hidden shadow-md shadow-purple-200">
            {{-- <div class="absolute inset-0 bg-gradient-to-r from-[#45016a]/70 to-[#ffc0cb]/40"></div> --}}
            @if($event->flyer_path)
                <img src="{{ asset('storage/'.$event->flyer_path) }}" alt="Flyer" class="h-64 w-full object-cover" />
            @else
                <div class="h-64 w-full bg-[#45016a]"></div>
            @endif
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-6" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">{{ $event->title }}</h1>
            <div class="mt-2 text-neutral-700">{{ optional($event->starts_at)->format('D, M j · g:i A') }}@if($event->venue) · {{ $event->venue }}@endif</div>
            <div class="mt-6 text-neutral-800">{!! nl2br(e($event->description)) !!}</div>
        </div>
    </section>
@endsection


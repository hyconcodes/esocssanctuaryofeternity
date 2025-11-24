@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-[#45016a]">Gallery</h1>
                <div class="flex gap-2">
                    @foreach(['Programs','Choir','Youth','Outreach'] as $f)
                        <button class="rounded-2xl border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]" data-filter="{{ strtolower($f) }}">{{ $f }}</button>
                    @endforeach
                </div>
            </div>
            <div class="mt-6 columns-1 sm:columns-2 lg:columns-3 gap-4">
                @php
                    $images = [
                        ['url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1200&auto=format&fit=crop', 'cat' => 'programs'],
                        ['url' => 'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?q=80&w=1200&auto=format&fit=crop', 'cat' => 'choir'],
                        ['url' => 'https://images.unsplash.com/photo-1453728013993-6db114c45e05?q=80&w=1200&auto=format&fit=crop', 'cat' => 'youth'],
                        ['url' => 'https://images.unsplash.com/photo-1526948128573-703ee1aeb6fa?q=80&w=1200&auto=format&fit=crop', 'cat' => 'outreach'],
                        ['url' => 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=1200&auto=format&fit=crop', 'cat' => 'programs'],
                        ['url' => 'https://images.unsplash.com/photo-1496307653780-42ee777d4833?q=80&w=1200&auto=format&fit=crop', 'cat' => 'choir'],
                        ['url' => 'https://images.unsplash.com/photo-1499696010220-10e8c1a9f1b3?q=80&w=1200&auto=format&fit=crop', 'cat' => 'youth'],
                        ['url' => 'https://images.unsplash.com/photo-1526948539054-3b71b482d95b?q=80&w=1200&auto=format&fit=crop', 'cat' => 'outreach'],
                    ];
                @endphp
                @foreach($images as $img)
                    <div class="mb-4 break-inside-avoid" data-category="{{ $img['cat'] }}">
                        <div class="group relative overflow-hidden rounded-2xl">
                            <img src="{{ $img['url'] }}" alt="Gallery" class="w-full object-cover transition duration-300 group-hover:scale-105" data-lightbox="{{ $img['url'] }}" />
                            <div class="absolute inset-0 bg-[#ffc0cb]/0 group-hover:bg-[#ffc0cb]/25 transition"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection


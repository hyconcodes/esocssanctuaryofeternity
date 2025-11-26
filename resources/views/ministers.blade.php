@extends('layouts.site')
@section('title','Ministers — ESOCS Platinum Branch')
@section('meta_description','Meet ministers and workers serving at ESOCS Sanctuary of Eternity.')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">Our Ministers & Workers</h1>
            <p class="mt-2 text-neutral-700">Pastors, ministers, and service heads serving our church family.</p>
            @php
                $ministers = \App\Models\Minister::orderBy('is_featured','desc')
                    ->orderBy('order','asc')
                    ->orderBy('created_at','desc')
                    ->get();
            @endphp
            @if($ministers->isEmpty())
                <div class="mt-6 text-center py-8 text-neutral-600">No ministers added yet.</div>
            @else
                <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($ministers as $m)
                        <div class="p-[2px] rounded-sm bg-gradient-to-r from-[#45016a] via-[#ffc0cb] to-[#45016a]">
                            <div class="rounded-sm bg-white p-6 shadow-md shadow-purple-200">
                                <div class="flex flex-col items-center text-center">
                                    <div class="relative">
                                        @if($m->photo_path)
                                            <img src="{{ asset('storage/'.$m->photo_path) }}" alt="{{ $m->name }}" class="size-24 lg:size-28 rounded-full object-cover ring-4 ring-[#ffc0cb]/60" />
                                        @else
                                            <div class="size-24 lg:size-28 rounded-full bg-[#ffc0cb] flex items-center justify-center text-[#45016a] text-2xl font-semibold ring-4 ring-[#ffc0cb]/60">{{ strtoupper(mb_substr($m->name,0,1)) }}</div>
                                        @endif
                                        @if($m->is_featured)
                                            <span class="absolute -bottom-2 right-0 px-2 py-1 text-xs rounded-full bg-pink-100 text-pink-700">Featured</span>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <div class="font-semibold text-[#45016a] text-lg">{{ $m->name }}</div>
                                        <div class="text-sm text-neutral-600">{{ $m->role }}</div>
                                        {{-- @if($m->department)
                                            <div class="text-xs text-neutral-500">{{ $m->department }}</div>
                                        @endif --}}
                                    </div>
                                    {{-- @if($m->bio)
                                        <p class="mt-3 text-sm text-neutral-700">{{ \Illuminate\Support\Str::limit($m->bio, 160) }}</p>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@extends('layouts.site')
@section('title','Gallery — ESOCS Platinum Branch')
@section('meta_description','Photos from worship, outreaches, programs, choir, and youth activities at ESOCS Sanctuary of Eternity.')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-[#45016a]">Gallery</h1>
            </div>
            <div id="mainGalleryGrid" class="mt-6 columns-1 sm:columns-2 lg:columns-3 gap-4">
                @php
                    $active = request('cat');
                    $images = \App\Models\GalleryImage::query()
                        ->when($active, function($q) use ($active){ $q->where('category', $active); })
                        ->orderBy('is_featured','desc')
                        ->orderBy('created_at','desc')
                        ->get();
                @endphp
                @forelse($images as $img)
                    <div class="mb-4 break-inside-avoid" data-category="{{ $img->category ?? '' }}">
                        <div class="group relative overflow-hidden rounded-sm">
                            <a href="{{ asset('storage/'.$img->image_path) }}" class="glightbox block" data-gallery="mainGallery" @if($img->title) data-title="{{ $img->title }}" @endif @if($img->description) data-description="{{ $img->description }}" @endif>
                                <img src="{{ asset('storage/'.$img->image_path) }}" alt="Gallery" class="w-full object-cover transition duration-300 group-hover:scale-105" />
                            </a>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition pointer-events-none"></div>
                            @if($img->category)
                                <span class="absolute top-2 left-2 z-10 px-2 py-1 text-xs rounded-full bg-white/20 text-white backdrop-blur">{{ ucfirst($img->category) }}</span>
                            @endif
                            @if($img->title || $img->description)
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-white opacity-0 group-hover:opacity-100 transition">
                                    @if($img->title)
                                        <div class="text-sm font-semibold truncate">{{ $img->title }}</div>
                                    @endif
                                    @if($img->description)
                                        <div class="text-xs text-white/90 line-clamp-2">{{ \Illuminate\Support\Str::limit($img->description, 100) }}</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-neutral-600">No gallery images yet.</div>
                @endforelse
            </div>
            <div class="mt-6 flex flex-wrap gap-2" id="mainGalleryCats">
                <button type="button" data-filter="all" data-target="#mainGalleryGrid" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb] bg-[#ffc0cb] border-[#ffc0cb]">All</button>
                @php $cats = ['Programs','Choir','Youth','Outreach']; @endphp
                @foreach($cats as $f)
                    @php $slug = strtolower($f); @endphp
                    <button type="button" data-filter="{{ $slug }}" data-target="#mainGalleryGrid" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">
                        {{ $f }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>
@endsection

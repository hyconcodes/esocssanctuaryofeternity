@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-[#45016a]">Sermons</h1>
                <div class="flex gap-2">
                    @foreach(['Sunday Services','Bible Study','Youth Fellowship'] as $f)
                        @php $slug = strtolower(str_replace(' ', '-', $f)); @endphp
                        <button class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]" data-filter="{{ $slug }}">{{ $f }}</button>
                    @endforeach
                </div>
            </div>
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="audiosGrid">
                @php
                    $audios = \App\Models\Audio::orderBy('is_featured','desc')->orderBy('created_at','desc')->get();
                @endphp
                @forelse($audios as $a)
                    <div class="rounded-sm p-5 bg-white border shadow-md shadow-purple-200" data-category="{{ $a->category ?? '' }}">
                        <div class="flex items-start gap-3">
                            <button class="rounded-sm bg-[#45016a] text-white p-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition" onclick="this.closest('.rounded-sm').querySelector('audio')?.play()">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M8 5.5v13l11-6.5-11-6.5Z" />
                                </svg>
                            </button>
                            <div class="flex-1">
                                <div class="font-semibold text-[#45016a]">{{ $a->title }}</div>
                                <div class="text-sm text-neutral-600">{{ ucwords(str_replace('-', ' ', $a->category ?? '')) }}</div>
                                @if($a->description)
                                    <p class="mt-2 text-sm text-neutral-700">{{ \Illuminate\Support\Str::limit($a->description, 140) }}</p>
                                @endif
                                @if($a->audio_path)
                                    <audio controls class="mt-3 w-full">
                                        <source src="{{ asset('storage/'.$a->audio_path) }}" />
                                    </audio>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-neutral-600">No audios yet.</div>
                @endforelse
            </div>
            <div class="mt-6 flex flex-wrap gap-2" id="audiosCats">
                <button type="button" data-filter="all" data-target="#audiosGrid" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb] bg-[#ffc0cb] border-[#ffc0cb]">All</button>
                @foreach(['Sunday Services','Bible Study','Youth Fellowship'] as $f)
                    @php $slug = strtolower(str_replace(' ', '-', $f)); @endphp
                    <button type="button" data-filter="{{ $slug }}" data-target="#audiosGrid" class="rounded-sm border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">{{ $f }}</button>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-[#45016a]">Sermons</h1>
                <div class="flex gap-2">
                    @foreach(['Sunday Services','Bible Study','Youth Fellowship'] as $f)
                        @php $slug = strtolower(str_replace(' ', '-', $f)); @endphp
                        <button class="rounded-2xl border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]" data-filter="{{ $slug }}">{{ $f }}</button>
                    @endforeach
                </div>
            </div>
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $sermons = [
                        ['title' => 'Walking in Love', 'cat' => 'sunday-services'],
                        ['title' => 'Faith that Works', 'cat' => 'bible-study'],
                        ['title' => 'Purity and Purpose', 'cat' => 'youth-fellowship'],
                    ];
                @endphp
                @foreach($sermons as $s)
                    <div class="rounded-2xl p-5 bg-white border shadow-md shadow-purple-200" data-category="{{ $s['cat'] }}">
                        <div class="flex items-center gap-3">
                            <button class="rounded-2xl bg-[#45016a] text-white p-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M8 5.5v13l11-6.5-11-6.5Z" />
                                </svg>
                            </button>
                            <div>
                                <div class="font-semibold text-[#45016a]">{{ $s['title'] }}</div>
                                <div class="text-sm text-neutral-600">{{ ucwords(str_replace('-', ' ', $s['cat'])) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                <a href="#" class="rounded-2xl bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Listen to sermons (Drive)</a>
            </div>
        </div>
    </section>
@endsection

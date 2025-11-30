@extends('layouts.site')
@section('title','Hymns')
@section('meta_description','Search and read hymns by number or title')

@section('content')
<section class="px-4 lg:px-10 mt-10" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-[#45016a]">Hymns</h2>
        </div>
        <form method="GET" action="{{ route('hymns') }}" class="mt-4 flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search by number or title" class="rounded-sm border p-3 w-full sm:w-80" />
            <button class="rounded-sm bg-[#45016a] text-white px-5 py-2 hover:bg-[#ffc0cb] hover:text-[#45016a]">Search</button>
        </form>

        @php $items = $items ?? collect(); @endphp
        @if(method_exists($items,'count') && $items->count())
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items as $h)
                    <a href="{{ route('hymns.read', $h->number) }}" class="rounded-sm border p-4 hover:bg-[#ffc0cb]/20 transition">
                        <div class="font-semibold text-[#45016a]">Hymn {{ $h->number }}</div>
                        <div class="text-sm text-neutral-700">{{ $h->title }}</div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">{{ $items->withQueryString()->links() }}</div>
        @else
            <div class="mt-6 text-center py-8 text-neutral-600">No hymns found.</div>
        @endif
    </div>
@endsection


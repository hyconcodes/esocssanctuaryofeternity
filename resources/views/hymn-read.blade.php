@extends('layouts.site')
@section('title','Hymn '.$hymn->number.' — '.$hymn->title)
@section('meta_description','Read hymn '.$hymn->number.' — '.$hymn->title)

@section('content')
<section class="px-4 lg:px-10 mt-10" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-[#45016a]">Hymn {{ $hymn->number }} — {{ $hymn->title }}</h1>
        @php
            $md = $hymn->content_md;
            $html = $md;
            $html = preg_replace('/^######\s*(.*)$/m', '<h6>$1</h6>', $html);
            $html = preg_replace('/^#####\s*(.*)$/m', '<h5>$1</h5>', $html);
            $html = preg_replace('/^####\s*(.*)$/m', '<h4>$1</h4>', $html);
            $html = preg_replace('/^###\s*(.*)$/m', '<h3>$1</h3>', $html);
            $html = preg_replace('/^##\s*(.*)$/m', '<h2>$1</h2>', $html);
            $html = preg_replace('/^#\s*(.*)$/m', '<h1 class="text-xl font-semibold text-[#45016a]">$1</h1>', $html);
            $html = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $html);
            $html = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $html);
            $html = preg_replace('/\[(.*?)\]\((.*?)\)/s', '<a href="$2" class="text-[#45016a] underline">$1</a>', $html);
            $html = preg_replace('/\n{2,}/', "\n\n", $html);
            $parts = array_filter(preg_split('/\n\n/', $html));
        @endphp
        <article class="mt-4 prose max-w-none">
            @foreach($parts as $p)
                {!! preg_match('/^<h[1-6]>/', $p) ? $p : '<p>'.nl2br($p).'</p>' !!}
            @endforeach
        </article>
    </div>
@endsection


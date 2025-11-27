<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>@yield('title', $title ?? config('app.name'))</title>
<meta name="description" content="@yield('meta_description', 'Sanctuary of Eternity. Home of signs and wonder..')">
<link rel="canonical" href="{{ url()->current() }}">
<meta name="robots" content="index,follow">
<meta property="og:site_name" content="ESOCS Sanctuary of Eternity">
<meta property="og:type" content="@yield('og_type','website')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', $title ?? config('app.name'))">
<meta property="og:description" content="@yield('meta_description', 'Sanctuary of Eternity. Home of signs and wonder..')">
<meta property="og:image" content="@yield('og_image', asset('assets/logo.png'))">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', $title ?? config('app.name'))">
<meta name="twitter:description" content="@yield('meta_description', 'Sanctuary of Eternity. Home of signs and wonder..')">
<meta name="twitter:image" content="@yield('og_image', asset('assets/logo.png'))">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="manifest" href="/manifest.webmanifest">
<meta name="theme-color" content="#45016a">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
@fluxAppearance
@yield('structured_data')

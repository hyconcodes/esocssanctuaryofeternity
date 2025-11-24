<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white text-neutral-900">
        <header class="sticky top-0 z-50 bg-[#45016a] text-white shadow-md">
            <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="/assets/logo.png" alt="Logo" class="h-20 w-25 rounded-lg" />
                    {{-- <span class="font-semibold">{{ config('app.name', 'ESOCS Platinum Branch') }}</span> --}}
                </a>
                <button id="mobileMenuButton" class="rounded-2xl bg-white/10 px-3 py-2 hover:bg-[#ffc0cb]/30 transition lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <nav class="hidden lg:block">
                    <ul class="flex items-center gap-1">
                        <li><a href="{{ route('home') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">About</a></li>
                        <li><a href="{{ route('events') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Events</a></li>
                        <li class="relative group">
                            <button class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition flex items-center gap-1">
                                Media
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 14.25a.75.75 0 0 1-.53-.22l-5-5a.75.75 0 1 1 1.06-1.06L12 12.44l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5a.75.75 0 0 1-.53.22Z" clip-rule="evenodd"/></svg>
                            </button>
                            <div class="absolute right-0 mt-2 hidden group-hover:block rounded-2xl bg-[#45016a] text-white shadow-md shadow-purple-200 border border-white/20 w-48">
                                <a href="{{ route('gallery') }}" class="block px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Gallery</a>
                                <a href="{{ route('audios') }}" class="block px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Audios</a>
                            </div>
                        </li>
                        <li><a href="{{ route('giving') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Giving</a></li>
                        <li><a href="{{ route('ministers') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Ministers</a></li>
                        <li><a href="{{ route('contact') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Contact</a></li>
                        {{-- <li class="ms-2"><a href="#" class="rounded-2xl px-4 py-2 bg-white text-[#45016a] font-semibold hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a></li> --}}
                        <li><a href="#" class="rounded-2xl px-4 py-2 border border-white/30 hover:bg-[#ffc0cb] transition">Join Us</a></li>
                    </ul>
                </nav>
            </div>
            <div id="topNavMenu" class="hidden lg:hidden border-t border-white/20">
                <div class="mx-auto max-w-7xl px-4 py-3 grid gap-2">
                    <a href="{{ route('home') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Home</a>
                    <a href="{{ route('about') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">About</a>
                    <a href="{{ route('events') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Events</a>
                    <button id="mediaToggle" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition flex items-center justify-between">
                        <span>Media</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 14.25a.75.75 0 0 1-.53-.22l-5-5a.75.75 0 1 1 1.06-1.06L12 12.44l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5a.75.75 0 0 1-.53.22Z" clip-rule="evenodd"/></svg>
                    </button>
                    <div id="mediaSubmenu" class="hidden ps-4 grid gap-2">
                        <a href="{{ route('gallery') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Gallery</a>
                        <a href="{{ route('audios') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Audios</a>
                    </div>
                    <a href="{{ route('giving') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Giving</a>
                    <a href="{{ route('ministers') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Ministers</a>
                    <a href="{{ route('contact') }}" class="rounded-2xl px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Contact</a>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        {{-- <a href="#" class="rounded-2xl px-4 py-2 text-center bg-white text-[#45016a] font-semibold hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a> --}}
                        <a href="#" class="rounded-2xl px-4 py-2 text-center border border-white/30 hover:bg-[#ffc0cb] transition">Join Us</a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="pt-0">
                @yield('content')
            </div>
        </main>
        </div>

        <footer class="mt-10">
            <div class="bg-[#45016a] text-white shadow-md shadow-purple-200">
                <div class="grid gap-6 p-6 lg:grid-cols-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <img src="/assets/logo.png" alt="Logo" class="h-8 w-12 rounded-lg" />
                            <div class="font-semibold">ESOCS Platinum Branch</div>
                        </div>
                        <p class="mt-3 text-sm text-white/80">Sanctuary of Eternity. Raising a holy, loving, and faithful people.</p>
                    </div>
                    <div>
                        <div class="font-semibold">Quick Links</div>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li><a href="{{ route('about') }}" class="hover:text-[#ffc0cb] transition">About</a></li>
                            <li><a href="{{ route('events') }}" class="hover:text-[#ffc0cb] transition">Events</a></li>
                            <li><a href="{{ route('gallery') }}" class="hover:text-[#ffc0cb] transition">Gallery</a></li>
                            <li><a href="{{ route('giving') }}" class="hover:text-[#ffc0cb] transition">Giving</a></li>
                            <li><a href="{{ route('audios') }}" class="hover:text-[#ffc0cb] transition">Audios</a></li>
                            <li><a href="{{ route('ministers') }}" class="hover:text-[#ffc0cb] transition">Ministers</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-[#ffc0cb] transition">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="font-semibold">Contact</div>
                        <ul class="mt-3 space-y-2 text-sm text-white/80">
                            <li>123 Sanctuary Road, Port Harcourt</li>
                            <li>+234 800 000 0000</li>
                            <li>info@esocsplatinum.org</li>
                        </ul>
                        <div class="mt-4 font-semibold">Service Times</div>
                        <ul class="mt-2 space-y-1 text-sm text-white/80">
                            <li>Sun: 8:00am & 10:00am</li>
                            <li>Wed: 5:00pm (Bible Study)</li>
                        </ul>
                    </div>
                    <div>
                        <div class="font-semibold">Follow</div>
                        <div class="mt-3 flex gap-2">
                            <a href="#" class="rounded-2xl p-2 bg-white/10 hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96s9.96-4.46 9.96-9.96c0-5.5-4.46-9.96-9.96-9.96Zm1.19 14.82h-2.25V10.5h2.25v6.36Zm-.06-7.65h-2.22V7.02h2.22v2.19Z"/></svg>
                            </a>
                            <a href="#" class="rounded-2xl p-2 bg-white/10 hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M12 2.04C6.5 2.04 2.04 6.5 2.04 12s4.46 9.96 9.96 9.96 9.96-4.46 9.96-9.96S17.5 2.04 12 2.04Zm3.76 7.12h-1.85c-1.45 0-1.73.69-1.73 1.7v1.42h3.37l-.44 3.42h-2.93v8.76H8.81v-8.76H7V12.28h1.81v-1.54c0-1.79.98-4.53 4.53-4.53l2.42.02v3.93Z"/></svg>
                            </a>
                            <a href="#" class="rounded-2xl p-2 bg-white/10 hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96s9.96-4.46 9.96-9.96c0-5.5-4.46-9.96-9.96-9.96Zm3.7 13.1c-1.89 0-3.42-1.53-3.42-3.42s1.53-3.42 3.42-3.42 3.42 1.53 3.42 3.42-1.53 3.42-3.42 3.42Zm0-5.22a1.8 1.8 0 1 0 0 3.6 1.8 1.8 0 0 0 0-3.6ZM7.21 7.21h3.6v3.6h-3.6v-3.6Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-white/20 px-6 py-3 text-sm text-white/80 flex items-center justify-between">
                    <span>© {{ date('Y') }} ESOCS Platinum Branch</span>
                    <span>Sanctuary of Eternity</span>
                </div>
            </div>
        </footer>

        <div id="lightbox" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80">
            <button id="lightboxClose" class="absolute top-4 right-4 rounded-2xl bg-white/10 px-3 py-2 text-white hover:bg-[#ffc0cb]/30">Close</button>
            <img id="lightboxImage" src="" alt="Preview" class="max-h-[85vh] max-w-[90vw] rounded-2xl shadow-md shadow-purple-200" />
        </div>

        @fluxScripts
    </body>
</html>

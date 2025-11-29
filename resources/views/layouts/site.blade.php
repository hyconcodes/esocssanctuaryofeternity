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
                <button id="mobileMenuButton" class="rounded-sm bg-white/10 px-3 py-2 hover:bg-[#ffc0cb]/30 transition lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <nav class="hidden lg:block">
                    <ul class="flex items-center gap-1">
                        <li><a href="{{ route('home') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Home</a></li>
                        {{-- <li><a href="{{ route('about') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">About</a></li> --}}
                        <li><a href="{{ route('events') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Events</a></li>
                        <li class="relative group">
                            <button class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition flex items-center gap-1">
                                Media
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 14.25a.75.75 0 0 1-.53-.22l-5-5a.75.75 0 1 1 1.06-1.06L12 12.44l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5a.75.75 0 0 1-.53.22Z" clip-rule="evenodd"/></svg>
                            </button>
                            <div class="absolute right-0 mt-2 hidden group-hover:block rounded-sm bg-[#45016a] text-white shadow-md shadow-purple-200 border border-white/20 w-48">
                                <a href="{{ route('gallery') }}" class="block px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Gallery</a>
                                <a href="{{ route('audios') }}" class="block px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Audios</a>
                            </div>
                        </li>
                        <li><a href="{{ route('giving') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Giving</a></li>
                        <li><a href="{{ route('ministers') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Ministers</a></li>
                        <li><a href="{{ route('contact') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Contact</a></li>
                        <li class="ms-2"><a href="https://www.youtube.com/channel/UCR1JTmJ37IapDPiJrmW9NDw" class="rounded-sm px-4 py-2 bg-white text-[#45016a] font-semibold hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a></li>
                        <li><a href="{{ route('membership') }}" class="rounded-sm px-4 py-2 border border-white/30 hover:bg-[#ffc0cb] transition">Join Us</a></li>
                    </ul>
                </nav>
            </div>
            <div id="topNavMenu" class="hidden lg:hidden border-t border-white/20">
                <div class="mx-auto max-w-7xl px-4 py-3 grid gap-2">
                    <a href="{{ route('home') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Home</a>
                    {{-- <a href="{{ route('about') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">About</a> --}}
                    <a href="{{ route('events') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Events</a>
                    <button id="mediaToggle" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition flex items-center justify-between">
                        <span>Media</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 14.25a.75.75 0 0 1-.53-.22l-5-5a.75.75 0 1 1 1.06-1.06L12 12.44l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5a.75.75 0 0 1-.53.22Z" clip-rule="evenodd"/></svg>
                    </button>
                    <div id="mediaSubmenu" class="hidden ps-4 grid gap-2">
                        <a href="{{ route('gallery') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Gallery</a>
                        <a href="{{ route('audios') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Audios</a>
                    </div>
                    <a href="{{ route('giving') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Giving</a>
                    <a href="{{ route('ministers') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Ministers</a>
                    <a href="{{ route('contact') }}" class="rounded-sm px-4 py-2 hover:bg-[#ffc0cb]/20 transition">Contact</a>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <a href="https://www.youtube.com/channel/UCR1JTmJ37IapDPiJrmW9NDw" class="rounded-sm px-4 py-2 text-center bg-white text-[#45016a] font-semibold hover:bg-[#ffc0cb] hover:text-[#45016a] transition">Watch Live</a>
                        <a href="{{ route('membership') }}" class="rounded-sm px-4 py-2 text-center border border-white/30 hover:bg-[#ffc0cb] transition">Join Us</a>
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
                <div class="grid gap-6 p-6 lg:grid-cols-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <img src="/assets/logo.png" alt="Logo" class="h-8 w-12 rounded-lg" />
                            <div>
                                <div class="font-semibold leading-tight">ESOCS Sanctuary of Eternity</div>
                                <div class="text-xs text-white/80">Platinum Branch</div>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-white/80">Sanctuary of Eternity. Home Of Success , Signs And Wonders.</p>
                        <div class="mt-3">
                            <a href="/manifest.webmanifest" data-pwa-install class="inline-block rounded-sm px-4 py-2 bg-white text-[#45016a] hover:bg-[#ffc0cb] transition">Download ESOCS SOE App</a>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold">Quick Links</div>
                        <div class="mt-3 flex flex-wrap gap-2 text-sm">
                            <a href="{{ route('events') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Events</a>
                            <a href="{{ route('gallery') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Gallery</a>
                            <a href="{{ route('giving') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Giving</a>
                            <a href="{{ route('audios') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Audios</a>
                            <a href="{{ route('ministers') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Ministers</a>
                            <a href="{{ route('contact') }}" class="rounded-sm px-3 py-1 bg-white/10 hover:bg-white/20 transition">Contact</a>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold">Contact</div>
                        @php
                            $setting = null;
                            if (\Illuminate\Support\Facades\Schema::hasTable('contact_settings')) {
                                $setting = \App\Models\ContactSetting::query()->orderBy('created_at','desc')->first();
                            }
                        @endphp
                        <ul class="mt-3 space-y-2 text-sm text-white/80">
                            <li>{{ optional($setting)->address ?? 'Ikwere Road, Adjacent Rumuokuta Flyover Bridge, Rumuokuta Port Harcourt. 54' }}</li>
                            <li>{{ optional($setting)->phone ?? '+234-8138703124' }}</li>
                            <li>{{ optional($setting)->email ?? 'sanctuaryofeternityhop@gmail.com' }}</li>
                        </ul>
                        <div class="mt-4 font-semibold">Service Times</div>
                        <ul class="mt-2 space-y-1 text-sm text-white/80">
                            <li>Tuesdays, 5:30 PM --- Bible Study -- The Exploration.</li>
                            <li>Fridays, 5:30 PM — Anointing And Deliverances Service ( ADS)</li>
                            <li class="mt-2 font-semibold text-white">SUNDAY WORSHIP SESSIONS</li>
                            <li>First Session — Workers Consecration and Ignite Prayers , 7:30 -- 8:00 AM</li>
                            <li>Second Session — Sunday School Service, 8:00 -- 9:00 AM</li>
                            <li>Third Session — Super Glorious Service, 9:00 - 11:30 AM.</li>
                            <li class="mt-2 font-semibold text-white">Faith Foundation School</li>
                            <li>Saturdays , 10:00 AM</li>
                            <li>Sundays ,  11:45 AM.</li>
                        </ul>
                    </div>
                    <div>
                        <div class="font-semibold">Follow</div>
                        <div class="mt-3 flex gap-2">
                            <a href="https://x.com/sanctuaryh88065?s=21" target="_blank" rel="noopener" class="rounded-sm p-2 bg-white/10 hover:bg-white/20 transition" aria-label="Twitter/X">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M18 2H21L13.5 10.5L21.5 22H15.5L10.5 14.5L4 22H1L8.5 13.5L1.5 2H7.5L12.5 9.5L18 2Z"/></svg>
                            </a>
                            <a href="https://www.youtube.com/channel/UCR1JTmJ37IapDPiJrmW9NDw" target="_blank" rel="noopener" class="rounded-sm p-2 bg-white/10 hover:bg-white/20 transition" aria-label="YouTube">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M23.5 6.7c-.2-1.4-1.3-2.4-2.7-2.6C18.7 3.8 12 3.8 12 3.8s-6.7 0-8.8.3C1.8 4.3.7 5.3.5 6.7.2 8.9 0 12 0 12s.2 3.1.5 5.3c.2 1.4 1.3 2.4 2.7 2.6 2.1.3 8.8.3 8.8.3s6.7 0 8.8-.3c1.4-.2 2.5-1.2 2.7-2.6.3-2.2.5-5.3.5-5.3s-.2-3.1-.5-5.3ZM9.6 15.5V8.5l6.6 3.5-6.6 3.5Z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/share/1HUKjScBYf/" target="_blank" rel="noopener" class="rounded-sm p-2 bg-white/10 hover:bg-white/20 transition" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-white"><path d="M13.5 20.5v-7h2.3l.3-3h-2.6V8.5c0-.9.3-1.5 1.5-1.5h1.2V4.3c-.6-.1-1.3-.3-2.1-.3-2.1 0-3.5 1.3-3.5 3.6v2.6H8v3h2.6v7h2.9Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-white/20 px-6 py-3 text-sm text-white/80 flex items-center justify-between">
                    <span>© {{ date('Y') }} ESOCS Sanctuary of Eternity</span>
                    <span>Platinum Branch</span>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function(){
                if (window.GLightbox) {
                    GLightbox({ selector: '.glightbox' });
                }

                document.addEventListener('click', function(e){
                    var btn = e.target.closest('[data-filter][data-target]');
                    if (!btn) return;
                    e.preventDefault();
                    var targetSel = btn.getAttribute('data-target');
                    var filter = btn.getAttribute('data-filter');
                    var container = document.querySelector(targetSel);
                    if (!container) return;
                    // update active state on siblings
                    var group = btn.parentElement;
                    group.querySelectorAll('[data-filter]').forEach(function(el){
                        el.classList.remove('bg-\[\#ffc0cb\]','border-\[\#ffc0cb\]');
                    });
                    btn.classList.add('bg-\[\#ffc0cb\]','border-\[\#ffc0cb\]');
                    // filter items
                    container.querySelectorAll('[data-category]').forEach(function(item){
                        if (filter === 'all' || (item.getAttribute('data-category') || '') === filter) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });

                document.addEventListener('click', function(e){
                    var cp = e.target.closest('[data-copy]');
                    if (!cp) return;
                    var text = cp.getAttribute('data-copy');
                    if (!text) return;
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(function(){
                            var prev = cp.textContent;
                            cp.textContent = 'Copied';
                            setTimeout(function(){ cp.textContent = prev; }, 1200);
                        });
                    }
                });

                document.addEventListener('click', function(e){
                    var openBtn = e.target.closest('[data-modal-open]');
                    if (openBtn) {
                        var sel = openBtn.getAttribute('data-modal-open');
                        var modal = document.querySelector(sel);
                        if (modal) modal.classList.remove('hidden');
                        e.preventDefault();
                        return;
                    }
                    var closeBtn = e.target.closest('[data-modal-close]');
                    if (closeBtn) {
                        var modal = closeBtn.closest('[data-modal]');
                        if (modal) modal.classList.add('hidden');
                        e.preventDefault();
                        return;
                    }
                });

                document.querySelectorAll('[data-autoscroll]').forEach(function(container){
                    var paused = false;
                    var step = 360;
                    var interval = 3500;
                    var timer = setInterval(function(){
                        if (paused) return;
                        var maxScrollLeft = container.scrollWidth - container.clientWidth;
                        var next = Math.min(container.scrollLeft + step, maxScrollLeft);
                        if (next >= maxScrollLeft) {
                            container.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            container.scrollTo({ left: next, behavior: 'smooth' });
                        }
                    }, interval);
                    container.addEventListener('mouseenter', function(){ paused = true; });
                    container.addEventListener('mouseleave', function(){ paused = false; });
                    window.addEventListener('beforeunload', function(){ clearInterval(timer); });
                });

                document.querySelectorAll('[data-carousel]').forEach(function(root){
                    var items = Array.from(root.querySelectorAll('[data-carousel-item]'));
                    if (!items.length) return;
                    var index = 0;
                    function show(i){
                        index = (i + items.length) % items.length;
                        for (var k=0;k<items.length;k++){
                            if (k === index) {
                                items[k].classList.remove('opacity-0','pointer-events-none','absolute');
                                items[k].classList.add('opacity-100','relative');
                            } else {
                                items[k].classList.remove('opacity-100','relative');
                                items[k].classList.add('opacity-0','pointer-events-none','absolute');
                            }
                        }
                    }
                    var autoplay = root.hasAttribute('data-autoplay');
                    var interval = parseInt(root.getAttribute('data-interval')) || 3500;
                    var paused = false;
                    var timer = null;
                    function start(){
                        if (!autoplay) return;
                        if (timer) clearInterval(timer);
                        timer = setInterval(function(){ if (!paused) show(index + 1); }, interval);
                    }
                    root.addEventListener('mouseenter', function(){ paused = true; });
                    root.addEventListener('mouseleave', function(){ paused = false; });
                    root.closest('.rounded-sm')?.querySelectorAll('[data-action="prev"]').forEach(function(btn){
                        btn.addEventListener('click', function(){ show(index - 1); start(); });
                    });
                    root.closest('.rounded-sm')?.querySelectorAll('[data-action="next"]').forEach(function(btn){
                        btn.addEventListener('click', function(){ show(index + 1); start(); });
                    });
                    show(0);
                    start();
                    window.addEventListener('beforeunload', function(){ if (timer) clearInterval(timer); });
                });
            });
        </script>

        @fluxScripts
    </body>
</html>

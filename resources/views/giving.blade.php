@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-2xl p-6 bg-[#ffc0cb] text-[#45016a] shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold">Giving / Donation</h1>
            <p class="mt-2 italic">“God loves a cheerful giver…” — 2 Corinthians 9:7</p>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 grid gap-6" data-animate>
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200 border border-[#ffc0cb]">
                <h2 class="text-xl font-semibold text-[#45016a]">Bank Transfer</h2>
                <p class="mt-3 text-neutral-700">Sterling Bank · ESOCS Platinum Branch</p>
                <p class="text-neutral-700">Acct Name: ESOCS Platinum Branch</p>
                <p class="text-neutral-700">Acct No: 0000000000</p>
            </div>
            <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200 border border-[#ffc0cb]">
                <h2 class="text-xl font-semibold text-[#45016a]">Giving Frequency</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach(['One-time','Weekly','Monthly','Quarterly'] as $f)
                        <button class="rounded-2xl border px-3 py-2 hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">{{ $f }}</button>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl p-6 bg-[#45016a] text-white shadow-md shadow-purple-200">
                <h2 class="text-xl font-semibold">Give Online</h2>
                <p class="mt-2">Use your card to give securely.</p>
                <div class="mt-4 flex gap-3">
                    <a href="#" class="rounded-2xl bg-white text-[#45016a] px-4 py-2 hover:bg-[#ffc0cb] hover:text-[#45016a]">Give via Card</a>
                    <a href="#" class="rounded-2xl bg-white/10 text-white px-4 py-2 hover:bg-white/20">Give via Transfer</a>
                </div>
            </div>
        </div>

        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-xl font-semibold text-[#45016a]">Bible Passages on Giving</h2>
            <ul class="mt-3 grid lg:grid-cols-2 gap-3 text-neutral-700">
                <li class="rounded-2xl border p-4">2 Corinthians 9:6–8</li>
                <li class="rounded-2xl border p-4">Luke 6:38</li>
                <li class="rounded-2xl border p-4">Proverbs 11:25</li>
                <li class="rounded-2xl border p-4">Malachi 3:10</li>
            </ul>
        </div>

        <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200">
            <h2 class="text-xl font-semibold text-[#45016a]">Online Card Form (Mockup)</h2>
            <form class="mt-4 grid lg:grid-cols-2 gap-4">
                <input type="text" placeholder="Cardholder Name" class="rounded-2xl border p-3" />
                <input type="text" placeholder="Card Number" class="rounded-2xl border p-3" />
                <input type="text" placeholder="Expiry (MM/YY)" class="rounded-2xl border p-3" />
                <input type="text" placeholder="CVV" class="rounded-2xl border p-3" />
                <input type="number" placeholder="Amount" class="rounded-2xl border p-3 lg:col-span-2" />
                <button class="rounded-2xl bg-[#45016a] text-white px-5 py-3 hover:bg-[#ffc0cb] hover:text-[#45016a] transition lg:col-span-2">Give Online</button>
            </form>
        </div>
    </section>
@endsection


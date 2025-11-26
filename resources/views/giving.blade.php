@extends('layouts.site')
@section('title','Support & Giving — ESOCS Platinum Branch')
@section('meta_description','Give offerings and support ministry work at ESOCS Sanctuary of Eternity.')

@section('content')
    <section class="px-4 lg:px-10 py-4" data-animate>
        <div class="rounded-sm p-6 bg-[#ffc0cb] text-[#45016a] shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold">Offerings & Donation</h1>
            <p class="mt-2 italic">Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver. Consider sharing a donation to support a good cause.</p>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 grid gap-6" data-animate>
        @php
            $giving = \App\Models\Giving::orderBy('is_featured','desc')->orderBy('created_at','desc')->first();
        @endphp
        <div class="p-[2px] rounded-sm bg-gradient-to-r from-[#45016a] via-[#ffc0cb] to-[#45016a]">
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 border">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-[#45016a]">
                            <path d="M3 10.5v9.25c0 .69.56 1.25 1.25 1.25h15.5c.69 0 1.25-.56 1.25-1.25V10.5H3Zm18-2.5V5.25c0-.69-.56-1.25-1.25-1.25H4.25C3.56 4 3 4.56 3 5.25V8h18ZM8 14h2v3H8v-3Zm6 0h2v3h-2v-3Z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-[#45016a]">Bank Transfer</h2>
                    </div>
                    @if($giving)
                        <button type="button" data-copy="{{ $giving->account_number }}" class="rounded-sm border px-3 py-2 text-sm hover:bg-[#ffc0cb] hover:border-[#ffc0cb]">Copy</button>
                    @endif
                </div>
                @if($giving)
                    <div class="mt-4 text-neutral-700 grid sm:grid-cols-2 gap-3">
                        <div>
                            <div class="text-xs text-neutral-500">Account Number</div>
                            <div class="text-lg font-semibold">{{ $giving->account_number }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-neutral-500">Account Name</div>
                            <div>{{ $giving->account_name }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-xs text-neutral-500">Bank Name</div>
                            <div>{{ $giving->bank_name }}</div>
                        </div>
                    </div>
                @else
                    <p class="mt-3 text-neutral-700">No account info yet.</p>
                @endif
            </div>
        </div>
    </section>
@endsection

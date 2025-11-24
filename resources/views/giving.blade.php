@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-[#ffc0cb] text-[#45016a] shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold">Offerings & Donation</h1>
            <p class="mt-2 italic">Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver. Consider sharing a donation to support a good cause.</p>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 grid gap-6" data-animate>
        @php
            $giving = \App\Models\Giving::orderBy('is_featured','desc')->orderBy('created_at','desc')->first();
        @endphp
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 border border-[#ffc0cb]">
            <h2 class="text-xl font-semibold text-[#45016a]">Bank Transfer</h2>
            @if($giving)
                <div class="mt-3 text-neutral-700">
                    <div class="text-lg font-semibold">{{ $giving->account_number }}</div>
                    <div>{{ $giving->account_name }}</div>
                    <div>{{ $giving->bank_name }}</div>
                </div>
            @else
                <p class="mt-3 text-neutral-700">No account info yet.</p>
            @endif
        </div>
    </section>
@endsection

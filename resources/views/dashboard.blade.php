<x-layouts.app :title="__('Dashboard')">
    <main class="px-4 lg:px-10 mt-6">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                <div class="text-sm font-semibold text-[#45016a]">Total Events</div>
                <div class="mt-2 text-3xl font-bold">{{ \Illuminate\Support\Facades\Schema::hasTable('events') ? \App\Models\Event::count() : 0 }}</div>
            </div>
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                <div class="text-sm font-semibold text-[#45016a]">Total Members</div>
                <div class="mt-2 text-3xl font-bold">{{ \Illuminate\Support\Facades\Schema::hasTable('memberships') ? \App\Models\Membership::count() : 0 }}</div>
            </div>
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                <div class="text-sm font-semibold text-[#45016a]">Unread Messages</div>
                <div class="mt-2 text-3xl font-bold">{{ \Illuminate\Support\Facades\Schema::hasTable('contact_messages') ? \App\Models\ContactMessage::where('is_read', false)->count() : 0 }}</div>
            </div>
        </div>

        @php
            $eventsByMonth = [];
            $maxEvents = 0;
            if (\Illuminate\Support\Facades\Schema::hasTable('events')) {
                $eventsThisYear = \App\Models\Event::whereYear('starts_at', now()->year)->get();
                for ($m = 1; $m <= 12; $m++) {
                    $eventsByMonth[$m] = $eventsThisYear->filter(function ($e) use ($m) {
                        return optional($e->starts_at)->month === $m;
                    })->count();
                }
                $maxEvents = max($eventsByMonth ?: [0]);
            } else {
                for ($m = 1; $m <= 12; $m++) { $eventsByMonth[$m] = 0; }
                $maxEvents = 0;
            }
        @endphp

        <div class="mt-6 rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold text-[#45016a]">Events per Month ({{ now()->year }})</div>
                <div class="text-xs text-neutral-600 dark:text-neutral-300">Total: {{ array_sum($eventsByMonth) }}</div>
            </div>
            @if(array_sum($eventsByMonth) > 0)
                <div class="mt-4 grid grid-cols-12 gap-2 items-end h-48">
                    @foreach(range(1,12) as $m)
                        @php $c = $eventsByMonth[$m] ?? 0; $h = $maxEvents ? intval($c / $maxEvents * 160) : 2; @endphp
                        <div class="relative flex flex-col items-center justify-end">
                            <div class="w-5 rounded-sm bg-[#45016a] dark:bg-[#ffc0cb]" style="height: {{ $h }}px"></div>
                            <div class="mt-2 text-[10px] text-neutral-600 dark:text-neutral-300">{{ \Carbon\Carbon::create(null, $m)->shortMonthName }}</div>
                            <div class="absolute -top-4 text-[10px] text-neutral-700 dark:text-neutral-300">{{ $c }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-3 text-sm text-neutral-600 dark:text-neutral-300">No event data for {{ now()->year }}.</div>
            @endif
        </div>
    </main>
</x-layouts.app>

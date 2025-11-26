<?php

use App\Models\ContactSetting;
use App\Models\ContactMessage;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithPagination::class]);

state([
    'editing' => null,
    'address' => '',
    'phone' => '',
    'email' => '',
    'map_embed_url' => '',
    'q' => '',
]);

$load = function () {
    $s = ContactSetting::query()->orderBy('created_at','desc')->first();
    if ($s) {
        $this->editing = $s->id;
        $this->address = $s->address ?? '';
        $this->phone = $s->phone ?? '';
        $this->email = $s->email ?? '';
        $this->map_embed_url = $s->map_embed_url ?? '';
    } else {
        $this->address = '54, Ikwere Road, Adjacent Rumuokuta Flyover Bridge, Rumuokuta Port Harcourt.';
        $this->phone = '+234-8138703124';
        $this->email = 'sanctuaryofeternityhop@gmail.com';
        $this->map_embed_url = 'https://www.google.com/maps?q=' . urlencode('54, Ikwere Road, Adjacent Rumuokuta Flyover Bridge, Rumuokuta Port Harcourt.') . '&output=embed';
    }
};

$contactMessages = computed(function () {
    $q = $this->q;
    $query = ContactMessage::query()->orderBy('created_at','desc');
    if ($q) {
        $query->where(function($qb) use($q){
            $qb->where('name','like','%'.$q.'%')
               ->orWhere('email','like','%'.$q.'%')
               ->orWhere('phone','like','%'.$q.'%')
               ->orWhere('message','like','%'.$q.'%');
        });
    }
    return $query->paginate(12);
});

$save = function () {
    $this->validate([
        'address' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email',
        'map_embed_url' => 'nullable|string',
    ]);
    $data = [
        'address' => $this->address,
        'phone' => $this->phone,
        'email' => $this->email,
        'map_embed_url' => $this->map_embed_url ?: null,
    ];
    if ($this->editing) {
        $s = ContactSetting::find($this->editing);
        if ($s) $s->update($data);
    } else {
        $s = ContactSetting::create($data);
        $this->editing = $s->id;
    }
    session()->flash('message', 'Contact settings saved');
};

$markRead = function ($id) {
    ContactMessage::whereKey($id)->update(['is_read' => true]);
};

$deleteMsg = function ($id) {
    ContactMessage::whereKey($id)->delete();
};
?>

<section class="px-4 lg:px-10 mt-6" x-init="$wire.load()" data-animate>
    <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100">
        <div class="text-2xl font-semibold text-[#45016a]">Manage Contact</div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-2xl p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">Contact Settings</div>
                <div class="mt-4 grid gap-3">
                    <textarea wire:model.live="address" rows="3" placeholder="Address" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <input type="text" wire:model.live="phone" placeholder="Phone" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="email" wire:model.live="email" placeholder="Email" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="text" wire:model.live="map_embed_url" placeholder="Map Embed URL (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-2xl bg-[#45016a] text-white px-4 py-2">Save</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="rounded-2xl p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                    <div class="flex items-center justify-between">
                        <div class="text-xl font-semibold text-[#45016a]">Messages</div>
                        <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    </div>
                    @if($this->contactMessages->isEmpty())
                        <div class="mt-4 text-sm text-neutral-600">No messages yet.</div>
                    @else
                        <div class="mt-4 grid gap-3">
                            @foreach($this->contactMessages as $m)
                                <div class="rounded-2xl p-4 border bg-white shadow-sm dark:bg-zinc-900 dark:border-zinc-700">
                                    <div class="flex items-center justify-between">
                                        <div class="font-semibold text-[#45016a] truncate">{{ $m->name ?: 'Anonymous' }}</div>
                                        <div class="text-xs text-neutral-600">{{ $m->created_at->format('M j, Y g:i A') }}</div>
                                    </div>
                                    <div class="text-xs text-neutral-700">{{ $m->email }} @if($m->phone) · {{ $m->phone }} @endif</div>
                                    <div class="mt-2 text-sm text-neutral-800">{{ $m->message }}</div>
                                    <div class="mt-2 flex gap-2">
                                        @if(!$m->is_read)
                                            <button wire:click="markRead({{ $m->id }})" class="rounded-2xl border px-3 py-2">Mark read</button>
                                        @endif
                                        <button wire:click="deleteMsg({{ $m->id }})" class="rounded-2xl border px-3 py-2 text-red-600">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">{{ $this->contactMessages->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>

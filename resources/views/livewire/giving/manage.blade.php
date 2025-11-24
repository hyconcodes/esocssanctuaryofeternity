<?php

use App\Models\Giving;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithPagination::class]);

state([
    'editing' => null,
    'account_number' => '',
    'account_name' => '',
    'bank_name' => '',
    'is_featured' => true,
]);

$accounts = computed(function () {
    return Giving::query()->orderBy('is_featured','desc')->orderBy('created_at','desc')->paginate(12);
});

$save = function () {
    $this->validate([
        'account_number' => 'required|string|max:32',
        'account_name' => 'required|string|max:255',
        'bank_name' => 'required|string|max:255',
        'is_featured' => 'boolean',
    ]);

    $data = [
        'account_number' => $this->account_number,
        'account_name' => $this->account_name,
        'bank_name' => $this->bank_name,
        'is_featured' => (bool) $this->is_featured,
    ];

    if ($this->editing) {
        $item = Giving::find($this->editing);
        if ($item) {
            $item->update($data);
            session()->flash('message', 'Giving info updated');
        }
    } else {
        Giving::create($data);
        session()->flash('message', 'Giving info added');
    }

    $this->reset(['editing','account_number','account_name','bank_name','is_featured']);
    $this->resetPage();
};

$edit = function ($id) {
    $item = Giving::find($id);
    if (!$item) return;
    $this->editing = $item->id;
    $this->account_number = $item->account_number;
    $this->account_name = $item->account_name;
    $this->bank_name = $item->bank_name;
    $this->is_featured = (bool)$item->is_featured;
};

$delete = function ($id) {
    Giving::whereKey($id)->delete();
};

$cancelEdit = function () {
    $this->reset(['editing','account_number','account_name','bank_name','is_featured']);
};
?>

<section class="px-4 lg:px-10 mt-6" data-animate>
    <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100">
        <div class="text-2xl font-semibold text-[#45016a]">Manage Giving</div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-2xl p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Info @else Add Info @endif</div>
                <div class="mt-4 grid gap-3">
                    <input type="text" wire:model.live="account_number" placeholder="Account Number" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="text" wire:model.live="account_name" placeholder="Account Name" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="text" wire:model.live="bank_name" placeholder="Bank Name" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model.live="is_featured" /> <span>Feature on site</span></label>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-2xl bg-[#45016a] text-white px-4 py-2">Save</button>
                        <button wire:click="cancelEdit" class="rounded-2xl border px-4 py-2">Reset</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->accounts->isEmpty())
                    <div class="text-center py-8 text-gray-500">No giving info yet.</div>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($this->accounts as $g)
                            <div class="rounded-2xl p-4 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="font-semibold text-[#45016a] truncate">{{ $g->account_number }}</div>
                                <div class="text-xs text-neutral-700 dark:text-neutral-300">{{ $g->account_name }}</div>
                                <div class="text-xs text-neutral-700 dark:text-neutral-300">{{ $g->bank_name }}</div>
                                @if($g->is_featured)
                                    <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-pink-100 text-pink-700">Featured</span>
                                @endif
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="edit({{ $g->id }})" class="rounded-2xl border px-3 py-2">Edit</button>
                                    <button wire:click="delete({{ $g->id }})" class="rounded-2xl border px-3 py-2 text-red-600">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->accounts->links() }}</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>

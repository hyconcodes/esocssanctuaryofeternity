<?php

use App\Models\Announcement;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithFileUploads::class, WithPagination::class]);

state([
    'q' => '',
    'editing' => null,
    'title' => '',
    'description' => '',
    'is_active' => false,
    'flyer' => null,
    'current_flyer_path' => '',
]);

$items = computed(function () {
    $query = Announcement::query()->orderBy('created_at', 'desc');
    if ($this->q) {
        $q = $this->q;
        $query->where(function ($qb) use ($q) {
            $qb->where('title', 'like', '%'.$q.'%')
               ->orWhere('description', 'like', '%'.$q.'%');
        });
    }
    return $query->paginate(12);
});

$save = function () {
    $this->validate([
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'flyer' => $this->editing ? 'nullable|image|max:4096' : 'required|image|max:4096',
        'is_active' => 'boolean',
    ]);

    $data = [
        'title' => $this->title ?: null,
        'description' => $this->description ?: null,
        'is_active' => (bool) $this->is_active,
    ];

    if ($this->flyer && is_object($this->flyer)) {
        $path = $this->flyer->store('announcements', 'public');
        $data['flyer_path'] = $path;
    }

    if ($this->editing) {
        $a = Announcement::find($this->editing);
        if ($a) {
            $a->update($data);
            session()->flash('message', 'Announcement updated');
        }
    } else {
        Announcement::create($data);
        session()->flash('message', 'Announcement created');
    }

    $this->reset(['editing','title','description','is_active','flyer']);
    $this->resetPage();
};

$edit = function ($id) {
    $a = Announcement::find($id);
    if (!$a) return;
    $this->editing = $a->id;
    $this->title = $a->title ?: '';
    $this->description = $a->description ?: '';
    $this->is_active = (bool) $a->is_active;
    $this->current_flyer_path = $a->flyer_path ?: '';
};

$delete = function ($id) {
    Announcement::whereKey($id)->delete();
};

$toggleActive = function ($id) {
    $a = Announcement::find($id);
    if ($a) {
        $a->is_active = !$a->is_active;
        $a->save();
        session()->flash('message', $a->is_active ? 'Announcement activated' : 'Announcement deactivated');
    }
};

$cancelEdit = function () {
    $this->reset(['editing','title','description','is_active','flyer']);
};
?>

<section class="px-4 sm:px-6 lg:px-10 mt-6" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100 dark:shadow-black/30 max-w-7xl mx-auto">
        @if (session()->has('message'))
            <div class="mb-4 p-4 rounded-sm bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Announcements</div>
            <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search announcements" class="w-full sm:w-64 rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
            </div>
        </div>

        <div class="mt-6 grid md:grid-cols-2 gap-6">
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Announcement @else Add Announcement @endif</div>
                @if ($errors->any())
                    <div class="mt-3 p-3 rounded-sm bg-red-100 text-red-700 text-sm dark:bg-red-900/30 dark:text-red-300">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mt-4 grid gap-3">
                    <input type="text" wire:model.live="title" placeholder="Title" class="w-full rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <textarea wire:model.live="description" rows="3" placeholder="Description" class="w-full rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <input type="file" wire:model.live="flyer" accept="image/*" class="w-full rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @if ($flyer && is_object($flyer))
                        <img src="{{ $flyer->temporaryUrl() }}" alt="Preview" class="h-56 sm:h-40 w-full rounded-sm object-cover" />
                    @elseif($editing && $current_flyer_path)
                        <img src="{{ asset('storage/'.$current_flyer_path) }}" alt="Current Flyer" class="h-56 sm:h-40 w-full rounded-sm object-cover" />
                    @endif
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model.live="is_active" /> <span>Show announcement popout</span></label>
                    <div class="flex gap-2 flex-wrap">
                        <button wire:click="save" class="rounded-sm bg-[#45016a] text-white px-4 py-2">Save</button>
                        <button wire:click="cancelEdit" class="rounded-sm border px-4 py-2">Reset</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->items->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">No announcements yet.</div>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($this->items as $an)
                            <div class="rounded-sm p-3 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="rounded-sm overflow-hidden">
                                    @if($an->flyer_path)
                                        <img src="{{ asset('storage/'.$an->flyer_path) }}" alt="Announcement" class="h-56 sm:h-40 w-full object-cover" />
                                    @endif
                                </div>
                                <div class="mt-2 text-sm text-neutral-700 dark:text-neutral-300 font-semibold truncate">{{ $an->title }}</div>
                                @if($an->is_active)
                                    <span class="mt-1 inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Active</span>
                                @else
                                    <span class="mt-1 inline-block px-2 py-1 text-xs rounded-full bg-neutral-100 text-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-300">Inactive</span>
                                @endif
                                <div class="mt-2 flex gap-2 flex-wrap">
                                    <button wire:click="toggleActive({{ $an->id }})" class="rounded-sm border px-3 py-2">{{ $an->is_active ? 'Deactivate' : 'Activate' }}</button>
                                    <button wire:click="edit({{ $an->id }})" class="rounded-sm border px-3 py-2">Edit</button>
                                    <button wire:click="delete({{ $an->id }})" class="rounded-sm border px-3 py-2 text-red-600">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->items->links() }}</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>

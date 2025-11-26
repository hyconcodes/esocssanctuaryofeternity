<?php

use App\Models\Minister;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithFileUploads::class, WithPagination::class]);

state([
    'q' => '',
    'editing' => null,
    'name' => '',
    'role' => '',
    'department' => '',
    'bio' => '',
    'is_featured' => false,
    'order' => 0,
    'photo' => null,
]);

$ministers = computed(function () {
    $query = Minister::query()
        ->orderBy('is_featured', 'desc')
        ->orderBy('order', 'asc')
        ->orderBy('created_at', 'desc');

    if ($this->q) {
        $q = $this->q;
        $query->where(function ($qb) use ($q) {
            $qb->where('name', 'like', '%'.$q.'%')
               ->orWhere('role', 'like', '%'.$q.'%')
               ->orWhere('department', 'like', '%'.$q.'%')
               ->orWhere('bio', 'like', '%'.$q.'%');
        });
    }

    return $query->paginate(12);
});

$save = function () {
    $this->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'department' => 'nullable|string|max:255',
        'bio' => 'nullable|string',
        'is_featured' => 'boolean',
        'order' => 'nullable|integer|min:0',
        'photo' => 'nullable|image|max:4096',
    ]);

    $data = [
        'name' => $this->name,
        'role' => $this->role,
        'department' => $this->department ?: null,
        'bio' => $this->bio ?: null,
        'is_featured' => (bool) $this->is_featured,
        'order' => $this->order ? (int) $this->order : 0,
    ];

    if ($this->photo && is_object($this->photo)) {
        $path = $this->photo->store('ministers', 'public');
        $data['photo_path'] = $path;
    }

    if ($this->editing) {
        $item = Minister::find($this->editing);
        if ($item) {
            $item->update($data);
            session()->flash('message', 'Minister updated');
        }
    } else {
        Minister::create($data);
        session()->flash('message', 'Minister created');
    }

    $this->reset(['editing','name','role','department','bio','is_featured','order','photo']);
    $this->resetPage();
};

$edit = function ($id) {
    $item = Minister::find($id);
    if (!$item) return;
    $this->editing = $item->id;
    $this->name = $item->name;
    $this->role = $item->role;
    $this->department = $item->department ?? '';
    $this->bio = $item->bio ?? '';
    $this->is_featured = (bool) $item->is_featured;
    $this->order = (int) ($item->order ?? 0);
};

$delete = function ($id) {
    $item = Minister::find($id);
    if ($item) {
        $item->delete();
        session()->flash('message', 'Minister deleted');
    }
};

$cancelEdit = function () {
    $this->reset(['editing','name','role','department','bio','is_featured','order','photo']);
};

?>

<main class="px-4 lg:px-10 mt-6 dark:bg-zinc-900 dark:text-neutral-100" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:shadow-black/30">
        @if (session()->has('message'))
            <div class="mb-4 p-4 rounded-sm bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Ministers</div>
            <div class="flex gap-2">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search ministers"
                       class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Minister @else Add Minister @endif</div>

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
                    <input type="text" wire:model.live="name" placeholder="Name" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="text" wire:model.live="role" placeholder="Role" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    {{-- <input type="text" wire:model.live="department" placeholder="Department (optional)" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" /> --}}
                    {{-- <textarea wire:model.live="bio" rows="3" placeholder="Bio (optional)" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea> --}}
                    <div class="grid lg:grid-cols-2 gap-3">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model.live="is_featured" class="w-4 h-4" />
                            <span>Feature on page</span>
                        </label>
                        <input type="number" wire:model.live="order" min="0" placeholder="Order" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    </div>
                    <div>
                        <input type="file" wire:model.live="photo" accept="image/*" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                        @if ($photo && is_object($photo))
                            <div class="mt-2">
                                <img src="{{ $photo->temporaryUrl() }}" class="h-24 w-24 rounded-sm object-cover" />
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-sm bg-[#45016a] text-white px-5 py-2">@if($editing) Update @else Save @endif</button>
                        <button wire:click="cancelEdit" class="rounded-sm border px-5 py-2">Cancel</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->ministers->isEmpty())
                    <div class="text-center py-8 text-neutral-600">No ministers yet.</div>
                @else
                    <div class="grid gap-4">
                        @foreach($this->ministers as $m)
                            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="flex items-start gap-4">
                                    @if($m->photo_path)
                                        <img src="{{ asset('storage/'.$m->photo_path) }}" alt="Photo" class="h-16 w-16 rounded-full object-cover" />
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-[#ffc0cb] flex items-center justify-center text-[#45016a]">{{ strtoupper(mb_substr($m->name,0,1)) }}</div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-[#45016a] truncate">{{ $m->name }}</div>
                                        <div class="text-sm text-neutral-600">{{ $m->role }}</div>
                                        {{-- @if($m->department)
                                            <div class="text-xs text-neutral-500">{{ $m->department }}</div>
                                        @endif --}}
                                        {{-- @if($m->bio)
                                            <p class="mt-2 text-sm text-neutral-700">{{ \Illuminate\Support\Str::limit($m->bio, 120) }}</p>
                                        @endif --}}
                                        @if($m->is_featured)
                                            <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-pink-100 text-pink-700">Featured</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2 flex-wrap">
                                    <button wire:click="edit({{ $m->id }})" class="rounded-sm border px-4 py-2 hover:bg-gray-100">Edit</button>
                                    <button wire:click="delete({{ $m->id }})" onclick="return confirm('Delete this minister?')" class="rounded-sm border border-red-300 px-4 py-2 text-red-600 hover:bg-red-50">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->ministers->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <div wire:loading class="mt-4 text-center">
        <div class="inline-block px-4 py-2 rounded-sm bg-purple-100 text-purple-700">
            <span class="animate-pulse">Loading...</span>
        </div>
    </div>
</main>

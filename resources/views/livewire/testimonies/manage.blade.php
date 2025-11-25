<?php

use App\Models\Testimony;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithFileUploads::class, WithPagination::class]);

state([
    'q' => '',
    'category' => '',
    'editing' => null,
    'title' => '',
    'description' => '',
    'author' => '',
    'author_photo' => null,
    'is_featured' => false,
    'gender' => '',
    'email' => '',
    'phone' => '',
    'country' => '',
    'rank' => '',
]);

$testimonies = computed(function () {
    $query = Testimony::query()->orderBy('is_featured','desc')->orderBy('created_at','desc');
    if ($this->q) {
        $q = $this->q;
        $query->where(function ($qb) use ($q) {
            $qb->where('title','like','%'.$q.'%')
               ->orWhere('description','like','%'.$q.'%')
               ->orWhere('author','like','%'.$q.'%')
               ->orWhere('category','like','%'.$q.'%');
        });
    }
    if ($this->category) {
        $query->where('category', $this->category);
    }
    return $query->paginate(12);
});

$save = function () {
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'author' => 'nullable|string|max:255',
        'category' => 'nullable|string|in:healing,breakthrough,family-reconciliation',
        'author_photo' => 'nullable|image|max:4096',
        'is_featured' => 'boolean',
        'gender' => 'nullable|string|max:32',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:32',
        'country' => 'nullable|string|max:64',
        'rank' => 'nullable|string|max:64',
    ]);

    $data = [
        'title' => $this->title,
        'description' => $this->description ?: null,
        'author' => $this->author ?: null,
        'category' => $this->category ?: null,
        'is_featured' => (bool) $this->is_featured,
        'gender' => $this->gender ?: null,
        'email' => $this->email ?: null,
        'phone' => $this->phone ?: null,
        'country' => $this->country ?: null,
        'rank' => $this->rank ?: null,
    ];

    if ($this->author_photo && is_object($this->author_photo)) {
        $path = $this->author_photo->store('testimonies', 'public');
        $data['author_photo_path'] = $path;
    }

    if ($this->editing) {
        $item = Testimony::find($this->editing);
        if ($item) {
            $item->update($data);
            session()->flash('message', 'Testimony updated');
        }
    } else {
        Testimony::create($data);
        session()->flash('message', 'Testimony added');
    }

    $this->reset(['editing','title','description','author','category','author_photo','is_featured','rank']);
    $this->reset(['gender','email','phone','country']);
    $this->resetPage();
};

$edit = function ($id) {
    $item = Testimony::find($id);
    if (!$item) return;
    $this->editing = $item->id;
    $this->title = $item->title;
    $this->description = $item->description ?: '';
    $this->author = $item->author ?: '';
    $this->category = $item->category ?: '';
    $this->is_featured = (bool)$item->is_featured;
    $this->gender = $item->gender ?: '';
    $this->email = $item->email ?: '';
    $this->phone = $item->phone ?: '';
    $this->country = $item->country ?: '';
    $this->rank = $item->rank ?: '';
};

$delete = function ($id) {
    Testimony::whereKey($id)->delete();
};

$cancelEdit = function () {
    $this->reset(['editing','title','description','author','category','author_photo','is_featured','rank']);
    $this->reset(['gender','email','phone','country']);
};
?>

<section class="px-4 lg:px-10 mt-6" data-animate>
    <div class="rounded-2xl p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Testimonies</div>
            <div class="flex gap-2">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                <select wire:model.live="category" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All</option>
                    <option value="healing">Healing</option>
                    <option value="breakthrough">Breakthrough</option>
                    <option value="family-reconciliation">Family Reconciliation</option>
                </select>
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-2xl p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Testimony @else Add Testimony @endif</div>
                <div class="mt-4 grid gap-3">
                    <input type="text" wire:model.live="title" placeholder="Title" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <input type="text" wire:model.live="author" placeholder="Name (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <select wire:model.live="category" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                        <option value="">Category (optional)</option>
                        <option value="healing">Healing</option>
                        <option value="breakthrough">Breakthrough</option>
                        <option value="family-reconciliation">Family Reconciliation</option>
                    </select>
                    <textarea wire:model.live="description" rows="4" placeholder="Description" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <div class="grid lg:grid-cols-2 gap-3">
                        <input type="text" wire:model.live="rank" placeholder="Rank / Position (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                        <select wire:model.live="gender" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                            <option value="">Gender (optional)</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <input type="email" wire:model.live="email" placeholder="Email (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                        <input type="text" wire:model.live="phone" placeholder="Phone (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                        <input type="text" wire:model.live="country" placeholder="Country (optional)" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    </div>
                    
                    <input type="file" wire:model="author_photo" accept="image/*" class="rounded-2xl border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @if ($author_photo && is_object($author_photo))
                        <img src="{{ $author_photo->temporaryUrl() }}" alt="Preview" class="h-20 w-20 rounded-full object-cover" />
                    @endif
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model.live="is_featured" /> <span>Feature on site</span></label>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-2xl bg-[#45016a] text-white px-4 py-2">Save</button>
                        <button wire:click="cancelEdit" class="rounded-2xl border px-4 py-2">Reset</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->testimonies->isEmpty())
                    <div class="text-center py-8 text-gray-500">No testimonies yet.</div>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($this->testimonies as $t)
                            <div class="rounded-2xl p-4 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="flex items-center gap-3">
                                    @if($t->author_photo_path)
                                        <img src="{{ asset('storage/'.$t->author_photo_path) }}" alt="Author" class="h-10 w-10 rounded-full object-cover border" />
                                    @endif
                                    <div class="font-semibold text-[#45016a] truncate">{{ $t->title }}</div>
                                </div>
                                <div class="text-xs text-neutral-700 dark:text-neutral-300">{{ ucwords(str_replace('-', ' ', $t->category ?? '')) }}</div>
                                @if($t->author)
                                    <div class="text-xs text-neutral-600 dark:text-neutral-300">By {{ $t->author }}</div>
                                @endif
                                @if($t->description)
                                    <p class="mt-2 text-sm text-neutral-700 dark:text-neutral-300">{{ \Illuminate\Support\Str::limit($t->description, 160) }}</p>
                                @endif
                                <div class="mt-1 text-xs text-neutral-600 dark:text-neutral-300">Rank: {{ $t->rank ?? 0 }}</div>
                                <div class="mt-1 text-xs text-neutral-600 dark:text-neutral-300">Gender: {{ $t->gender ?? 'n/a' }} · Country: {{ $t->country ?? 'n/a' }}</div>
                                <div class="text-xs text-neutral-600 dark:text-neutral-300">Email: {{ $t->email ?? 'n/a' }} · Phone: {{ $t->phone ?? 'n/a' }}</div>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="edit({{ $t->id }})" class="rounded-2xl border px-3 py-2">Edit</button>
                                    <button wire:click="delete({{ $t->id }})" class="rounded-2xl border px-3 py-2 text-red-600">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->testimonies->links() }}</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>

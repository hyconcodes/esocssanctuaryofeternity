<?php

use App\Models\GalleryImage;
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
    'image' => null,
    'is_featured' => false,
]);

$images = computed(function () {
    $query = GalleryImage::query()->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
    if ($this->q) {
        $q = $this->q;
        $query->where(function ($qb) use ($q) {
            $qb->where('title', 'like', '%'.$q.'%')
               ->orWhere('description', 'like', '%'.$q.'%')
               ->orWhere('category', 'like', '%'.$q.'%');
        });
    }
    if ($this->category) {
        $query->where('category', $this->category);
    }
    return $query->paginate(12);
});

$save = function () {
    $this->validate([
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|in:programs,choir,youth,outreach',
        'image' => $this->editing ? 'nullable|image|max:4096' : 'required|image|max:4096',
        'is_featured' => 'boolean',
    ]);

    $data = [
        'title' => $this->title ?: null,
        'description' => $this->description ?: null,
        'category' => $this->category ?: null,
        'is_featured' => (bool) $this->is_featured,
    ];

    if ($this->image && is_object($this->image)) {
        $path = $this->image->store('gallery', 'public');
        $data['image_path'] = $path;
    }

    if ($this->editing) {
        $img = GalleryImage::find($this->editing);
        if ($img) {
            $img->update($data);
            session()->flash('message', 'Image updated');
        }
    } else {
        GalleryImage::create($data);
        session()->flash('message', 'Image added');
    }

    $this->reset(['editing','title','description','category','image','is_featured']);
    $this->resetPage();
};

$edit = function ($id) {
    $img = GalleryImage::find($id);
    if (!$img) return;
    $this->editing = $img->id;
    $this->title = $img->title ?: '';
    $this->description = $img->description ?: '';
    $this->category = $img->category ?: '';
    $this->is_featured = (bool) $img->is_featured;
};

$delete = function ($id) {
    GalleryImage::whereKey($id)->delete();
};

$cancelEdit = function () {
    $this->reset(['editing','title','description','category','image','is_featured']);
};
?>

<section class="px-4 lg:px-10 mt-6" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Gallery</div>
            <div class="flex gap-2">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search images" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                <select wire:model.live="category" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All</option>
                    <option value="programs">Programs</option>
                    <option value="choir">Choir</option>
                    <option value="youth">Youth</option>
                    <option value="outreach">Outreach</option>
                </select>
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Image @else Add Image @endif</div>
                <div class="mt-4 grid gap-3">
                    <input type="text" wire:model.live="title" placeholder="Title" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <textarea wire:model.live="description" rows="3" placeholder="Description" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <select wire:model.live="category" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                        <option value="">Select Category</option>
                        <option value="programs">Programs</option>
                        <option value="choir">Choir</option>
                        <option value="youth">Youth</option>
                        <option value="outreach">Outreach</option>
                    </select>
                    <input type="file" wire:model="image" accept="image/*" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @if ($image && is_object($image))
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-40 rounded-sm object-cover" />
                    @endif
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model.live="is_featured" /> <span>Feature on site</span></label>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-sm bg-[#45016a] text-white px-4 py-2">Save</button>
                        <button wire:click="cancelEdit" class="rounded-sm border px-4 py-2">Reset</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->images->isEmpty())
                    <div class="text-center py-8 text-gray-500">No images yet.</div>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($this->images as $gi)
                            <div class="rounded-sm p-3 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="rounded-sm overflow-hidden">
                                    <a href="{{ asset('storage/'.$gi->image_path) }}" class="glightbox block" data-gallery="adminGallery" @if($gi->title) data-title="{{ $gi->title }}" @endif @if($gi->description) data-description="{{ $gi->description }}" @endif>
                                        <img src="{{ asset('storage/'.$gi->image_path) }}" alt="Gallery" class="h-40 w-full object-cover" />
                                    </a>
                                </div>
                                <div class="mt-2 text-sm text-neutral-700 dark:text-neutral-300">{{ $gi->title }}</div>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="edit({{ $gi->id }})" class="rounded-sm border px-3 py-2">Edit</button>
                                    <button wire:click="delete({{ $gi->id }})" class="rounded-sm border px-3 py-2 text-red-600">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->images->links() }}</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>

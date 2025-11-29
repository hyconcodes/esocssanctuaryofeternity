<?php

use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithFileUploads::class, WithPagination::class]);

state([
    'q' => '',
    'category' => '',
    'title' => '',
    'description' => '',
    'is_featured' => false,
    'audio' => null,
]);

$audios = computed(function () {
    $query = Audio::query()->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
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
    try {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|in:sunday-services,bible-study,youth-fellowship',
            'audio' => 'required|mimetypes:audio/mpeg,audio/mp4,audio/x-wav,audio/ogg|max:8192',
            'is_featured' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description ?: null,
            'category' => $this->category ?: null,
            'is_featured' => (bool) $this->is_featured,
        ];

        if ($this->audio && is_object($this->audio)) {
            $path = $this->audio->store('audios', 'public');
            $data['audio_path'] = $path;
        }

        Audio::create($data);
        session()->flash('message', 'Audio added successfully');

        $this->reset(['title','description','category','is_featured','audio']);
        $this->resetPage();
    } catch (\Illuminate\Validation\ValidationException $ve) {
        Log::warning('Audio validation failed', ['errors' => $ve->errors(), 'user_id' => auth()->id()]);
        throw $ve;
    } catch (\Throwable $e) {
        Log::error('Failed to save audio', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'user_id' => auth()->id()]);
        session()->flash('error', 'Failed to save audio: ' . $e->getMessage());
    }
};

$delete = function ($id) {
    try {
        $audio = Audio::find($id);
        if ($audio) {
            // Optionally delete the file from storage
            if ($audio->audio_path && \Storage::disk('public')->exists($audio->audio_path)) {
                \Storage::disk('public')->delete($audio->audio_path);
            }
            $audio->delete();
            session()->flash('message', 'Audio deleted successfully');
        }
    } catch (\Throwable $e) {
        Log::error('Failed to delete audio', ['error' => $e->getMessage(), 'id' => $id, 'user_id' => auth()->id()]);
        session()->flash('error', 'Failed to delete audio');
    }
};

$resetForm = function () {
    $this->reset(['title','description','category','is_featured','audio']);
};
?>

<section class="px-4 lg:px-10 mt-6" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100">
        @if (session()->has('message'))
            <div class="mb-4 p-4 rounded-sm bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-4 rounded-sm bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Audios</div>
            <div class="flex gap-2">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                <select wire:model.live="category" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All</option>
                    <option value="sunday-services">Sunday Services</option>
                    <option value="bible-study">Bible Study</option>
                    <option value="youth-fellowship">Youth Fellowship</option>
                </select>
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                <div class="text-xl font-semibold text-[#45016a]">Add Audio</div>
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
                    <input type="text" wire:model="title" placeholder="Title" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <textarea wire:model="description" rows="3" placeholder="Description" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <select wire:model="category" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                        <option value="">Select Category</option>
                        <option value="sunday-services">Sunday Services</option>
                        <option value="bible-study">Bible Study</option>
                        <option value="youth-fellowship">Youth Fellowship</option>
                    </select>
                    <input type="file" wire:model="audio" accept="audio/*" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @if ($audio)
                        <div class="text-sm text-green-600">File ready: {{ $audio->getClientOriginalName() }}</div>
                    @endif
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_featured" /> <span>Feature on site</span></label>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-sm bg-[#45016a] text-white px-4 py-2" wire:loading.attr="disabled">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading>Uploading...</span>
                        </button>
                        <button wire:click="resetForm" class="rounded-sm border px-4 py-2">Reset</button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->audios->isEmpty())
                    <div class="text-center py-8 text-gray-500">No audios yet.</div>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($this->audios as $au)
                            <div class="rounded-sm p-4 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                                <div class="font-semibold text-[#45016a] truncate">{{ $au->title }}</div>
                                <div class="text-xs text-neutral-700 dark:text-neutral-300">{{ ucwords(str_replace('-', ' ', $au->category ?? '')) }}</div>
                                @if($au->is_featured)
                                    <span class="inline-block mt-1 px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">Featured</span>
                                @endif
                                <div class="mt-2">
                                    @if($au->audio_path)
                                        <audio controls class="w-full">
                                            <source src="{{ asset('storage/'.$au->audio_path) }}" />
                                        </audio>
                                    @endif
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="delete({{ $au->id }})" 
                                            wire:confirm="Are you sure you want to delete this audio?"
                                            class="rounded-sm border px-3 py-2 text-red-600 hover:bg-red-50">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->audios->links() }}</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>
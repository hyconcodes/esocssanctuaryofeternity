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
    'editing' => null,
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
        // Check if audio file actually exists when it should
        if (!$this->editing && !$this->audio) {
            session()->flash('error', 'Please select an audio file to upload');
            return;
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|in:sunday-services,bible-study,youth-fellowship',
            'audio' => $this->editing ? 'nullable|file|mimes:mp3,mp4,wav,ogg,m4a|max:8192' : 'required|file|mimes:mp3,mp4,wav,ogg,m4a|max:8192',
            'is_featured' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description ?: null,
            'category' => $this->category ?: null,
            'is_featured' => (bool) $this->is_featured,
        ];

        if ($this->audio && is_object($this->audio)) {
            try {
                $path = $this->audio->store('audios', 'public');
                $data['audio_path'] = $path;
            } catch (\Exception $e) {
                Log::error('Failed to store audio file', [
                    'error' => $e->getMessage(),
                    'user_id' => auth()->id()
                ]);
                session()->flash('error', 'Failed to upload audio file. Please try again.');
                return;
            }
        }

        if ($this->editing) {
            $item = Audio::find($this->editing);
            if ($item) {
                $item->update($data);
                session()->flash('message', 'Audio updated');
            } else {
                session()->flash('error', 'Audio not found');
                Log::error('Audio not found during update', ['id' => $this->editing, 'user_id' => auth()->id()]);
            }
        } else {
            Audio::create($data);
            session()->flash('message', 'Audio added');
        }

        $this->reset(['editing','title','description','category','is_featured','audio']);
        $this->resetPage();
    } catch (\Illuminate\Validation\ValidationException $ve) {
        Log::warning('Audio validation failed', ['errors' => $ve->errors(), 'user_id' => auth()->id()]);
        
        // Check for specific file upload errors
        if (isset($ve->errors()['audio'])) {
            $audioErrors = $ve->errors()['audio'];
            if (in_array('The audio failed to upload.', $audioErrors)) {
                session()->flash('error', 'File upload failed. Check: file size (max 8MB), server upload limits, and storage permissions.');
                Log::error('File upload system failure', [
                    'max_upload' => ini_get('upload_max_filesize'),
                    'post_max' => ini_get('post_max_size'),
                    'storage_writable' => is_writable(storage_path('app/public')),
                    'user_id' => auth()->id()
                ]);
            }
        }
        throw $ve;
    } catch (\Throwable $e) {
        Log::error('Failed to save audio', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'user_id' => auth()->id()]);
        session()->flash('error', 'Failed to save audio: ' . $e->getMessage());
    }
};

$edit = function ($id) {
    $item = Audio::find($id);
    if (!$item) return;
    $this->editing = $item->id;
    $this->title = $item->title;
    $this->description = $item->description ?: '';
    $this->category = $item->category ?: '';
    $this->is_featured = (bool) $item->is_featured;
};

$delete = function ($id) {
    Audio::whereKey($id)->delete();
};

$cancelEdit = function () {
    $this->reset(['editing','title','description','category','is_featured','audio']);
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
                <div class="text-xl font-semibold text-[#45016a]">@if($editing) Edit Audio @else Add Audio @endif</div>
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
                    <input type="text" wire:model.live="title" placeholder="Title" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    <textarea wire:model.live="description" rows="3" placeholder="Description" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    <select wire:model.live="category" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700">
                        <option value="">Select Category</option>
                        <option value="sunday-services">Sunday Services</option>
                        <option value="bible-study">Bible Study</option>
                        <option value="youth-fellowship">Youth Fellowship</option>
                    </select>
                    <input type="file" wire:model="audio" accept="audio/*" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700 {{ $errors->has('audio') ? 'border-red-500' : '' }}" @if(!$editing) required @endif />
                    <div class="text-xs text-neutral-600 dark:text-neutral-400">mp3, mp4, wav, ogg · max 8MB · required when adding</div>
                    @if($errors->has('audio'))
                        <div class="text-xs text-red-600 dark:text-red-300">{{ $errors->first('audio') }}</div>
                    @endif
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model.live="is_featured" /> <span>Feature on site</span></label>
                    <div class="flex gap-2">
                        <button wire:click="save" class="rounded-sm bg-[#45016a] text-white px-4 py-2 {{ (!$editing && !$audio) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (!$editing && !$audio) ? 'disabled' : '' }}>Save</button>
                        <button wire:click="cancelEdit" class="rounded-sm border px-4 py-2">Reset</button>
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
                                <div class="mt-2">
                                    @if($au->audio_path)
                                        <audio controls class="w-full">
                                            <source src="{{ asset('storage/'.$au->audio_path) }}" />
                                        </audio>
                                    @endif
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="edit({{ $au->id }})" class="rounded-sm border px-3 py-2">Edit</button>
                                    <button wire:click="delete({{ $au->id }})" class="rounded-sm border px-3 py-2 text-red-600">Delete</button>
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
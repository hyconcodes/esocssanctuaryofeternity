<?php

use App\Models\Event;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, layout, uses};

// layout('layouts.site');
uses([WithFileUploads::class, WithPagination::class]);

state([
    'q' => '', 
    'category' => '', 
    'editing' => null, 
    'title' => '', 
    'description' => '', 
    'venue' => '', 
    'starts_at' => '', 
    'ends_at' => '', 
    'is_featured' => false, 
    'flyer' => null
]);

$events = computed(function () {
    $query = Event::query()->orderBy('starts_at', 'asc');
    
    if ($this->q) {
        $q = $this->q;
        $query->where(function ($qb) use ($q) {
            $qb->where('title', 'like', '%'.$q.'%')
               ->orWhere('description', 'like', '%'.$q.'%')
               ->orWhere('venue', 'like', '%'.$q.'%');
        });
    }
    
    if ($this->category) {
        $query->where('category', $this->category);
    }
    
    return $query->paginate(10);
});

$save = function () {
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'venue' => 'nullable|string|max:255',
        'starts_at' => 'required|date',
        'ends_at' => 'nullable|date|after:starts_at',
        'category' => 'nullable|string|in:program,outreach,choir',
        'flyer' => 'nullable|image|max:2048',
    ]);

    $data = [
        'title' => $this->title,
        'slug' => Str::slug($this->title),
        'description' => $this->description,
        'venue' => $this->venue,
        'starts_at' => $this->starts_at ? \Carbon\Carbon::parse($this->starts_at) : null,
        'ends_at' => $this->ends_at ? \Carbon\Carbon::parse($this->ends_at) : null,
        'category' => $this->category ?: null,
        'is_featured' => (bool) $this->is_featured,
    ];

    if ($this->flyer && is_object($this->flyer)) {
        $path = $this->flyer->store('flyers', 'public');
        $data['flyer_path'] = $path;
    }

    if ($this->editing) {
        $event = Event::find($this->editing);
        if ($event) {
            $event->update($data);
            session()->flash('message', 'Event updated successfully!');
        }
    } else {
        Event::create($data);
        session()->flash('message', 'Event created successfully!');
    }

    $this->reset(['editing', 'title', 'description', 'venue', 'starts_at', 'ends_at', 'category', 'is_featured', 'flyer']);
    $this->resetPage();
};

$edit = function ($id) {
    $event = Event::find($id);
    if (!$event) return;
    
    $this->editing = $event->id;
    $this->title = $event->title;
    $this->description = $event->description;
    $this->venue = $event->venue;
    $this->starts_at = optional($event->starts_at)->format('Y-m-d\TH:i');
    $this->ends_at = optional($event->ends_at)->format('Y-m-d\TH:i');
    $this->category = $event->category ?? '';
    $this->is_featured = (bool) $event->is_featured;
};

$delete = function ($id) {
    $event = Event::find($id);
    if ($event) {
        $event->delete();
        session()->flash('message', 'Event deleted successfully!');
    }
};

$cancelEdit = function () {
    $this->reset(['editing', 'title', 'description', 'venue', 'starts_at', 'ends_at', 'category', 'is_featured', 'flyer']);
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
            <div class="text-2xl font-semibold text-[#45016a]">Manage Events</div>
            <div class="flex gap-2">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="q" 
                    placeholder="Search events..." 
                    class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 placeholder:text-gray-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100 dark:placeholder:text-gray-500" 
                />
                <select 
                    wire:model.live="category" 
                    class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100"
                >
                    <option value="">All Categories</option>
                    <option value="program">Program</option>
                    <option value="outreach">Outreach</option>
                    <option value="choir">Choir</option>
                </select>
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-5 border border-[#ffc0cb] bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                <div class="text-xl font-semibold text-[#45016a]">
                    @if($editing) Edit Event @else Create Event @endif
                </div>
                
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
                    <input 
                        type="text" 
                        wire:model="title" 
                        placeholder="Event Title *" 
                        class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100" 
                    />
                    
                    <textarea 
                        wire:model="description" 
                        rows="4" 
                        placeholder="Event Description" 
                        class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100"
                    ></textarea>
                    
                    <input 
                        type="text" 
                        wire:model="venue" 
                        placeholder="Venue Location" 
                        class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100" 
                    />
                    
                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1 dark:text-gray-300">Start Date & Time *</label>
                            <input 
                                type="datetime-local" 
                                wire:model="starts_at" 
                                class="w-full rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100" 
                            />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1 dark:text-gray-300">End Date & Time</label>
                            <input 
                                type="datetime-local" 
                                wire:model="ends_at" 
                                class="w-full rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100" 
                            />
                        </div>
                    </div>
                    
                    <select 
                        wire:model="category" 
                        class="rounded-sm border border-gray-300 p-3 focus:outline-none focus:border-purple-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100"
                    >
                        <option value="">Select Category</option>
                        <option value="program">Program</option>
                        <option value="outreach">Outreach</option>
                        <option value="choir">Choir</option>
                    </select>
                    
                    <div>
                        <label class="block text-sm text-gray-600 mb-1 dark:text-gray-300">Event Flyer</label>
                        <input 
                            type="file" 
                            wire:model="flyer" 
                            accept="image/*"
                            class="w-full rounded-sm border border-gray-300 p-3 dark:bg-zinc-800 dark:border-zinc-700 dark:text-neutral-100" 
                        />
                        @if ($flyer && is_object($flyer))
                            <div class="mt-2">
                                <img src="{{ $flyer->temporaryUrl() }}" alt="Preview" class="h-32 rounded-sm object-cover" />
                            </div>
                        @endif
                    </div>
                    
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="w-4 h-4" /> 
                        <span class="text-gray-700 dark:text-gray-300">Feature this event on homepage</span>
                    </label>
                    
                    <div class="flex gap-2 mt-2">
                        <button 
                            wire:click="save" 
                            class="rounded-sm bg-[#45016a] text-white px-6 py-2 hover:bg-purple-800 transition"
                        >
                            {{ $editing ? 'Update Event' : 'Create Event' }}
                        </button>
                        <button 
                            wire:click="cancelEdit" 
                            class="rounded-sm border border-gray-300 px-6 py-2 hover:bg-gray-100 transition dark:border-zinc-700 dark:text-neutral-100 dark:hover:bg-zinc-800"
                        >
                            {{ $editing ? 'Cancel' : 'Clear' }}
                        </button>
                    </div>
                </div>
            </div>

            <div>
                @if($this->events->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No events found. Create your first event!
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach($this->events as $ev)
                            <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700 dark:shadow-black/30">
                                <div class="flex items-start gap-4">
                                    @if($ev->flyer_path)
                                        <img 
                                            src="{{ asset('storage/'.$ev->flyer_path) }}" 
                                            alt="Event Flyer" 
                                            class="h-20 w-32 rounded-sm object-cover flex-shrink-0" 
                                        />
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-[#45016a] truncate">{{ $ev->title }}</div>
                                        <div class="text-sm text-neutral-700 mt-1 dark:text-neutral-300">
                                            {{ optional($ev->starts_at)->format('D, M j · g:i A') }}
                                            @if($ev->venue) · {{ $ev->venue }}@endif
                                        </div>
                                        @if($ev->category)
                                            <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                                                {{ ucfirst($ev->category) }}
                                            </span>
                                        @endif
                                        @if($ev->is_featured)
                                            <span class="inline-block mt-2 ml-1 px-2 py-1 text-xs rounded-full bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2 flex-wrap">
                                    <a 
                                        href="{{ route('events.read', $ev->slug) }}" 
                                        class="inline-block rounded-sm px-4 py-2 border hover:bg-[#ffc0cb] transition dark:border-zinc-700 dark:text-neutral-100 dark:hover:bg-[#ffc0cb]/20"
                                    >
                                        View Details
                                    </a>
                                    <button 
                                        wire:click="edit({{ $ev->id }})" 
                                        class="rounded-sm border border-gray-300 px-4 py-2 hover:bg-gray-100 transition dark:border-zinc-700 dark:text-neutral-100 dark:hover:bg-zinc-800"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        wire:click="delete({{ $ev->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this event?')"
                                        class="rounded-sm border border-red-300 px-4 py-2 text-red-600 hover:bg-red-50 transition dark:border-red-700 dark:text-red-400 dark:hover:bg-red-900/20"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $this->events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div wire:loading class="mt-4 text-center">
        <div class="inline-block px-4 py-2 rounded-sm bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
            <span class="animate-pulse">Loading...</span>
        </div>
    </div>

</main>

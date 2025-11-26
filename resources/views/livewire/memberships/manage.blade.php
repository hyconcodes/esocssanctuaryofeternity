<?php

use App\Models\Membership;
use Livewire\WithPagination;
use function Livewire\Volt\{state, computed, uses};

uses([WithPagination::class]);

state([
    'q' => '',
    'date_from' => '',
    'date_to' => '',
]);

$memberships = computed(function () {
    $query = Membership::query()->orderBy('created_at','desc');

    if ($this->q) {
        $q = $this->q;
        $query->where(function($qb) use($q){
            $qb->where('name','like','%'.$q.'%')
               ->orWhere('email','like','%'.$q.'%')
               ->orWhere('phone1','like','%'.$q.'%')
               ->orWhere('membership_id','like','%'.$q.'%');
        });
    }

    if ($this->date_from) {
        $query->whereDate('created_at', '>=', $this->date_from);
    }
    if ($this->date_to) {
        $query->whereDate('created_at', '<=', $this->date_to);
    }

    return $query->paginate(12);
});

$delete = function ($id) {
    $m = Membership::find($id);
    if ($m) {
        $m->delete();
        session()->flash('message', 'Membership deleted');
    }
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
            <div class="text-2xl font-semibold text-[#45016a]">Manage Memberships</div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search by name, email, phone, ID" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                <input type="date" wire:model.live="date_from" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                <input type="date" wire:model.live="date_to" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
            </div>
        </div>

        <div class="mt-6">
            @if($this->memberships->isEmpty())
                <div class="text-center py-8 text-neutral-600">No membership records.</div>
            @else
                <div class="grid gap-4">
                    @foreach($this->memberships as $m)
                        <div class="rounded-sm p-5 border bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:border-zinc-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-[#45016a]">{{ $m->name }}</div>
                                    <div class="text-sm text-neutral-600">{{ $m->email }} · {{ $m->phone1 }}</div>
                                </div>
                                <div class="text-sm text-neutral-600">Submitted: {{ optional($m->created_at)->format('Y-m-d') }}</div>
                            </div>

                            <div class="mt-4 grid lg:grid-cols-4 gap-4">
                                <div>
                                    <div class="text-xs text-neutral-500">Priesthood Office</div>
                                    <div class="text-sm text-neutral-700">{{ $m->priesthood_office }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-500">Location</div>
                                    <div class="text-sm text-neutral-700">{{ $m->city }}, {{ $m->state }}, {{ $m->country }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-500">Member ID</div>
                                    <div class="text-sm text-neutral-700">{{ $m->membership_id }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-neutral-500">Membership Year</div>
                                    <div class="text-sm text-neutral-700">{{ $m->membership_year }}</div>
                                </div>
                            </div>

                            <div class="mt-4 grid lg:grid-cols-2 gap-4">
                                <div class="rounded-sm border p-4">
                                    <div class="font-semibold text-[#45016a]">Personal Information</div>
                                    <div class="mt-2 grid sm:grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs text-neutral-500">Email</div>
                                            <div class="text-sm text-neutral-700">{{ $m->email }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Phone 1</div>
                                            <div class="text-sm text-neutral-700">{{ $m->phone1 }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Phone 2</div>
                                            <div class="text-sm text-neutral-700">{{ $m->phone2 ?: '—' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Date of Birth</div>
                                            <div class="text-sm text-neutral-700">{{ optional($m->dob)->format('Y-m-d') }}</div>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="text-xs text-neutral-500">Residential Address</div>
                                            <div class="text-sm text-neutral-700">{{ $m->address }}</div>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="text-xs text-neutral-500">Relation/Caregiver</div>
                                            <div class="text-sm text-neutral-700">{{ $m->relation_or_caregiver ?: '—' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Occupation</div>
                                            <div class="text-sm text-neutral-700">{{ ucwords(str_replace('-', ' ', $m->occupation)) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Occupation (Other)</div>
                                            <div class="text-sm text-neutral-700">{{ $m->occupation_other ?: '—' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-sm border p-4">
                                    <div class="font-semibold text-[#45016a]">Status & Faith</div>
                                    <div class="mt-2 grid sm:grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs text-neutral-500">Relationship Status</div>
                                            <div class="text-sm text-neutral-700">{{ ucfirst($m->relationship_status) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Spouse Name</div>
                                            <div class="text-sm text-neutral-700">{{ $m->spouse_name ?: '—' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Children</div>
                                            <div class="text-sm text-neutral-700">{{ is_null($m->children_count) ? '—' : $m->children_count }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-neutral-500">Faith Graduation</div>
                                            <div class="text-sm text-neutral-700">{{ optional($m->faith_grad_date)->format('Y-m-d') ?: '—' }}</div>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="text-xs text-neutral-500">Department in Church</div>
                                            <div class="text-sm text-neutral-700">{{ $m->faith_department ?: '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <button wire:click="delete({{ $m->id }})" onclick="return confirm('Delete this record?')" class="rounded-sm border border-red-300 px-4 py-2 text-red-600 hover:bg-red-50 dark:border-red-700 dark:hover:bg-red-900/20">Delete</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $this->memberships->links() }}</div>
            @endif
        </div>
    </div>

    <div wire:loading class="mt-4 text-center">
        <div class="inline-block px-4 py-2 rounded-sm bg-purple-100 text-purple-700">
            <span class="animate-pulse">Loading...</span>
        </div>
    </div>
</main>

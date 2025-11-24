@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h1 class="text-3xl font-bold text-[#45016a]">Our Ministers & Workers</h1>
            <p class="mt-2 text-neutral-700">Pastors, ministers, and service heads serving our church family.</p>
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $people = [
                        ['name' => 'Pastor John Doe', 'role' => 'Resident Pastor', 'img' => 'https://images.unsplash.com/photo-1544457070-4dffaaff2d36?q=80&w=800&auto=format&fit=crop'],
                        ['name' => 'Minister Jane Smith', 'role' => 'Choir Director', 'img' => 'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?q=80&w=800&auto=format&fit=crop'],
                        ['name' => 'Bro. Michael', 'role' => 'Youth Leader', 'img' => 'https://images.unsplash.com/photo-1453728013993-6db114c45e05?q=80&w=800&auto=format&fit=crop'],
                        ['name' => 'Sis. Grace', 'role' => 'Ushering Head', 'img' => 'https://images.unsplash.com/photo-1499696010220-10e8c1a9f1b3?q=80&w=800&auto=format&fit=crop'],
                        ['name' => 'Deacon Peter', 'role' => 'Prayer Coordinator', 'img' => 'https://images.unsplash.com/photo-1526948539054-3b71b482d95b?q=80&w=800&auto=format&fit=crop'],
                        ['name' => 'Mrs. Ruth', 'role' => 'Children’s Church', 'img' => 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=800&auto=format&fit=crop'],
                    ];
                @endphp
                @foreach($people as $p)
                    <div class="p-[2px] rounded-sm bg-gradient-to-r from-[#45016a] via-[#ffc0cb] to-[#45016a]">
                        <div class="rounded-sm bg-white p-5 shadow-md shadow-purple-200 transition hover:shadow-lg">
                            <div class="flex items-center gap-4">
                                <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}" class="size-16 rounded-full object-cover" />
                                <div>
                                    <div class="font-semibold text-[#45016a]">{{ $p['name'] }}</div>
                                    <div class="text-sm text-neutral-600">{{ $p['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection


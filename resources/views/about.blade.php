@extends('layouts.site')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="relative overflow-hidden rounded-sm shadow-md shadow-purple-200">
            <div class="absolute inset-0 bg-gradient-to-r from-[#45016a]/80 via-[#45016a]/60 to-[#ffc0cb]/60"></div>
            <img src="https://images.unsplash.com/photo-1544457070-4dffaaff2d36?q=80&w=1600&auto=format&fit=crop" alt="Hero" class="h-64 lg:h-80 w-full object-cover" />
            <div class="absolute inset-0 flex items-center px-6 lg:px-10 text-white">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold">About ESOCS Platinum Branch</h1>
                    <p class="mt-3 max-w-2xl text-white/90">Our story, vision, and commitment to the gospel in our city.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 mt-10 grid gap-6" data-animate>
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h2 class="text-2xl font-semibold text-[#45016a]">Church History</h2>
                <p class="mt-3 text-neutral-700">Founded as part of ESOCS mission across the nation, Platinum Branch has grown into a vibrant congregation committed to worship, discipleship, and outreach.</p>
            </div>
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h2 class="text-2xl font-semibold text-[#45016a]">Leadership Statement</h2>
                <p class="mt-3 text-neutral-700">We serve under Christ, shepherding with humility, integrity, and diligence—equipping the saints for the work of ministry.</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h3 class="text-xl font-semibold text-[#45016a]">Vision</h3>
                <p class="mt-2 text-neutral-700">To be a sanctuary where the presence of God transforms lives and society.</p>
            </div>
            <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
                <h3 class="text-xl font-semibold text-[#45016a]">Mission</h3>
                <p class="mt-2 text-neutral-700">To proclaim Christ, disciple believers, and serve our community with love.</p>
            </div>
        </div>

        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h3 class="text-xl font-semibold text-[#45016a]">Core Values</h3>
            <div class="mt-4 grid sm:grid-cols-3 lg:grid-cols-6 gap-3">
                @foreach(['Love','Unshakable Faith','Holiness','Respect','Diligence','Service'] as $v)
                    <div class="rounded-sm border border-[#ffc0cb] p-4 text-center">{{ $v }}</div>
                @endforeach
            </div>
        </div>

        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <h3 class="text-xl font-semibold text-[#45016a]">What We Believe</h3>
            <ul class="mt-3 grid lg:grid-cols-2 gap-3 text-neutral-700">
                <li class="rounded-sm border p-4">The Bible is God’s inspired Word.</li>
                <li class="rounded-sm border p-4">Salvation by grace through faith in Jesus Christ.</li>
                <li class="rounded-sm border p-4">The church as Christ’s body called to unity and service.</li>
                <li class="rounded-sm border p-4">The Holy Spirit empowers believers for holy living.</li>
            </ul>
        </div>
    </section>
@endsection

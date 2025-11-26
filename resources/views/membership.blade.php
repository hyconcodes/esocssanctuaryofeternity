@extends('layouts.site')
@section('title','Membership — ESOCS Platinum Branch')
@section('meta_description','Register to become a member of ESOCS Sanctuary of Eternity and join our community.')

@section('content')
    <section class="px-4 lg:px-10" data-animate>
        <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200">
            <div class="text-3xl font-bold text-[#45016a]">Membership Registration</div>
            @if (session('message'))
                <div class="mt-3 rounded-sm bg-green-100 text-green-700 p-3">{{ session('message') }}</div>
            @endif
            <form method="POST" action="{{ route('membership.submit') }}" class="mt-6 grid gap-6" id="membershipForm">
                @csrf
                <div class="rounded-sm border p-5">
                    <div class="text-xl font-semibold text-[#45016a]">Section 1: Membership Registration</div>
                    <p class="mt-2 text-neutral-700">Please complete the form to register for membership. Fields marked with * are required.</p>
                    <p class="mt-2 text-neutral-700">Please be informed that this form is for collecting details of all members of Sanctuary Of Eternity - ESOCS Platinum Branch, Rumuokwuta, Port Harcourt, Rivers State, Nigeria. Kindly ensure all entries are correct and accurate.</p>
                </div>

                <div class="rounded-sm border p-5">
                    <div class="text-xl font-semibold text-[#45016a]">Section 2: Personal Information</div>
                    <div class="mt-3 grid lg:grid-cols-2 gap-3">
                        <input type="email" name="email" placeholder="Email *" required class="rounded-sm border p-3" />
                        <input type="text" name="name" placeholder="Name *" required class="rounded-sm border p-3" />
                        <input type="text" name="priesthood_office" placeholder="Priesthood office/Ordination Rank *" required class="rounded-sm border p-3" />
                        <input type="text" name="phone1" placeholder="Phone Number 1 *" required class="rounded-sm border p-3" />
                        <input type="text" name="phone2" placeholder="Phone Number 2" class="rounded-sm border p-3" />
                        <textarea name="relation_or_caregiver" rows="3" placeholder="Name of Relation or Caregiver if aged" class="rounded-sm border p-3 lg:col-span-2"></textarea>
                        <input type="date" name="dob" placeholder="Date of Birth *" required class="rounded-sm border p-3" />
                        <textarea name="address" rows="3" placeholder="Residential Address *" required class="rounded-sm border p-3 lg:col-span-2"></textarea>
                        <input type="text" name="city" placeholder="City *" required class="rounded-sm border p-3" />
                        <select name="state" required class="rounded-sm border p-3">
                            <option value="">State/Region *</option>
                            @php $states = ['Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue','Borno','Cross River','Delta','Ebonyi','Edo','Ekiti','Enugu','Gombe','Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara','Lagos','Nasarawa','Niger','Ogun','Ondo','Osun','Oyo','Plateau','Rivers','Sokoto','Taraba','Yobe','Zamfara','FCT']; @endphp
                            @foreach($states as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        <select name="country" required class="rounded-sm border p-3">
                            <option value="">Country *</option>
                            @php $countries = ['Nigeria','Ghana','Cameroon','Kenya','South Africa','United Kingdom','United States','Canada','Germany','France','Italy','Spain','China','India','Brazil','Japan','Australia']; @endphp
                            @foreach($countries as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                        <div class="grid lg:grid-cols-2 gap-3 lg:col-span-2">
                            <select name="occupation" required class="rounded-sm border p-3" id="occupationSelect">
                                <option value="">Occupation *</option>
                                <option value="teacher">Teacher</option>
                                <option value="doctor">Doctor</option>
                                <option value="engineer">Engineer</option>
                                <option value="nurse">Nurse</option>
                                <option value="civil-servant">Civil Servant</option>
                                <option value="self-employed">Self Employed</option>
                                <option value="other">Other</option>
                            </select>
                            <input type="text" name="occupation_other" placeholder="If Other, specify" class="rounded-sm border p-3 hidden" id="occupationOther" />
                        </div>
                    </div>
                </div>

                <div class="rounded-sm border p-5">
                    <div class="text-xl font-semibold text-[#45016a]">Section 3: Status</div>
                    <div class="mt-3 grid gap-3">
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="relationship_status" value="single" required /> <span>Single</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="relationship_status" value="married" required /> <span>Married</span></label>
                        </div>
                    </div>
                </div>

                <div class="rounded-sm border p-5 hidden" id="sectionMarried">
                    <div class="text-xl font-semibold text-[#45016a]">Section 4: Married</div>
                    <div class="mt-3 grid lg:grid-cols-2 gap-3">
                        <input type="text" name="spouse_name" placeholder="Name of Spouse *" class="rounded-sm border p-3" />
                        <select name="children_count" class="rounded-sm border p-3">
                            <option value="">Number of Child/Children *</option>
                            <option value="0">Nil</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-sm border p-5">
                    <div class="text-xl font-semibold text-[#45016a]">Section 5: Membership</div>
                    <div class="mt-3 grid lg:grid-cols-2 gap-3">
                        <input type="text" name="membership_year" placeholder="Year of Membership *" required class="rounded-sm border p-3" />
                        <input type="text" name="membership_id" placeholder="Membership Identification Number *" required class="rounded-sm border p-3" />
                    </div>
                </div>

                <div class="rounded-sm border p-5">
                    <div class="text-xl font-semibold text-[#45016a]">Section 6: Faith Foundation School</div>
                    <div class="mt-3 grid lg:grid-cols-2 gap-3">
                        <input type="date" name="faith_grad_date" placeholder="Date of Graduation" class="rounded-sm border p-3" />
                        <input type="text" name="faith_department" placeholder="Department in Church" class="rounded-sm border p-3" />
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="reset" class="rounded-sm border px-5 py-2">Clear</button>
                    <button class="rounded-sm bg-[#45016a] text-white px-5 py-2 hover:bg-[#ffc0cb] hover:text-[#45016a]">Submit</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var occSel = document.getElementById('occupationSelect');
            var occOther = document.getElementById('occupationOther');
            function toggleOccOther(){
                var show = occSel && occSel.value === 'other';
                if (occOther) occOther.classList.toggle('hidden', !show);
            }
            occSel && occSel.addEventListener('change', toggleOccOther);
            toggleOccOther();

            var marriedSection = document.getElementById('sectionMarried');
            document.getElementById('membershipForm').addEventListener('change', function(e){
                if (e.target.name === 'relationship_status'){
                    var isMarried = e.target.value === 'married';
                    marriedSection && marriedSection.classList.toggle('hidden', !isMarried);
                }
            });
        });
    </script>
@endsection

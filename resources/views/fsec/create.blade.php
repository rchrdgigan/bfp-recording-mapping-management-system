@section('title')
FSEC New Transaction
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl leading-tight">
          {{ __('Add FSEC for Building Permit') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('fsec.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        <x-jet-validation-errors class="mb-4 mt-5" />
        <x-success/>
        <x-error/>
        <form action="{{route('fsec.store')}}" method="post">
            @csrf
            <div class="flex mt-5 max-w-4xl mx-auto">
                <div class="w-full">
                    <div class="intro-y box p-10">
                        <h1 class="text-lg font-semibold text-center p-5">Map Setting</h1>
                        <div style="height:500px;">
                            <x-map/>
                        </div>
                        <div class="flex gap-2">
                            <x-jet-input id="lat" class="block mt-1 col-6 w-full" type="text" name="lat" :value="old('lat')" readonly placeholder="Click the map to auto generated lat or latitude" />
                            <x-jet-input id="lng" class="block mt-1 col-6 w-full" type="text" name="lng" :value="old('lng')" readonly placeholder="Click the map to auto generated lng or longitude" />
                        </div>
                        <h1 class="text-lg font-semibold text-center pt-5">Building Permit Information</h1>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="fsec_no" value="{{ __('FSEC No.') }}" />
                            <x-jet-input id="fsec_no" class="block mt-1 w-full" type="text" name="fsec_no" :value="old('fsec_no')" required/>
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="estab" value="{{ __('Name of Project') }}" />
                            <x-jet-input id="estab" class="block mt-1 w-full" type="text" name="project" :value="old('project')" required/>
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="owner" value="{{ __('Name of Owner') }}" />
                            <x-jet-input id="owner" class="block mt-1 w-full" type="text" name="owner" :value="old('owner')" required />
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="contact" value="{{ __('Contact Number') }}" />
                            <x-jet-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required />
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="address" value="{{ __('Address') }}" />
                            <x-select-location />
                        </div>
                        <div class="flex intro-y gap-2">
                            <div class="mt-4 col-span-6">
                                <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                                <x-jet-input id="valid_from" class="block mt-1 w-full" type="date" name="valid_from" :value="old('valid_from')" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required />
                            </div>
                            <div class="mt-4 col-span-6">
                                <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                                <x-jet-input id="valid_to" class="block mt-1 w-full" type="date" name="valid_to" :value="old('valid_to')" value="{{Carbon\Carbon::now()->addYear()->format('Y-m-d')}}" required />
                            </div>
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="amount" value="{{ __('Amount') }}" />
                            <x-jet-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')" required />
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                            <x-jet-input id="ops_no" class="block mt-1 w-full" type="text" name="ops_no" :value="old('ops_no')" required />
                        </div>
                        <div class="mt-4 intro-y">
                            <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                            <x-jet-input id="or_no" class="block mt-1 w-full" type="text" name="or_no" :value="old('or_no')" required />
                        </div>
                        
                        <div class="mt-4 intro-y">
                            <x-jet-button>
                                {{ __('Save') }}
                            </x-jet-button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</x-app-layout>
<script src="{{asset('dist/js/map.js')}}"></script>
<script>
    var popup = L.popup()
        .setLatLng([12.703562025451129, 124.03654038906099])
        .setContent("Set location!")
        .openOn(map);

    function onMapClick(e) {
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }
    map.on('click', onMapClick);

    @foreach($fsecs as $data)
    L.marker([{{$data->latitude}}, {{$data->longitude}}], {icon: office}).addTo(map)
    .bindPopup('<h2>{{$data->establishment}}</h2><a class="text-xs">{{$data->address}}</a>')
    .openPopup();
    @endforeach
</script>

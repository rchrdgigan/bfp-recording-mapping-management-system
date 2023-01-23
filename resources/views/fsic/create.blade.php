@section('title')
FSIC New Transaction
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-bold text-xl text-gray-800 leading-tight">
          {{ __('Add FSIC for Business') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('fsic.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        <x-jet-validation-errors class="mb-4 mt-5" />
        <x-success/>
        <x-error/>
        <form action="{{route('fsic.store')}}" method="post">
            @csrf
            <div class="pos grid grid-cols-12 gap-5 mt-5">

                <div class="col-span-12 lg:col-span-6">
                    <div class="intro-y box p-10">
                        <h1 class="text-lg font-semibold text-center p-5">Map Setting</h1>
                        <div style="height:500px;">
                            <x-map/>
                        </div>
                        <div class="flex gap-2">
                            <x-jet-input id="lat" class="block mt-1 col-6 w-full" type="text" name="lat" :value="old('lat')" readonly placeholder="Click the map to auto generated lat or latitude" />
                            <x-jet-input id="lng" class="block mt-1 col-6 w-full" type="text" name="lng" :value="old('lng')" readonly placeholder="Click the map to auto generated lng or longitude" />
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-6 p-2">
                    <h1 class="text-white text-lg font-bold text-center pt-5">Business Information</h1>
                    <div class="grid grid-cols-12 gap-5 mt-5">
                        
                        <div class="col-span-12 lg:col-span-6">
                            <!-- <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="fsic_no">{{ __('FSIC No.') }}</label>
                                <x-jet-input id="fsic_no" class="block mt-1 w-full" type="text" name="fsic_no" :value="old('fsic_no')" required />
                            </div> -->
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="estab">{{ __('Name of Establishment') }}</label>
                                <x-jet-input id="estab" class="block mt-1 w-full" type="text" name="establishment" :value="old('establishment')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="owner">{{ __('Name of Owner') }}</label>
                                <x-jet-input id="owner" class="block mt-1 w-full" type="text" name="owner" :value="old('owner')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="business_types">{{ __('Business Types') }}</label>
                                <x-jet-input id="business_types" class="block mt-1 w-full" type="text" name="business_types" :value="old('business_types')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="contact">{{ __('Contact Number') }}</label>
                                <x-jet-input id="contact" class="block mt-1 w-full" minlength="11" maxlength="11" type="text" name="contact" :value="old('contact')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="address">{{ __('Address') }}</label>
                                <x-select-location/>
                            </div>
                            
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            
                            <div class="grid grid-cols-12 intro-y gap-2">
                                <div class="mt-4 col-span-6">
                                    <label class="block font-medium text-sm text-white" for="valid_from">{{ __('Valid For') }}</label>
                                    <x-jet-input id="valid_from" class="block mt-1 w-full" type="date" name="valid_from" :value="old('valid_from')" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required />
                                </div>
                                <div class="mt-4 col-span-6">
                                    <label class="block font-medium text-sm text-white" for="valid_to">{{ __('Valid Until') }}</label>
                                    <x-jet-input id="valid_to" class="block mt-1 w-full" type="date" name="valid_to" :value="old('valid_to')" value="{{Carbon\Carbon::now()->addYear()->format('Y-m-d')}}" required />
                                </div>
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="amount">{{ __('Amount') }}</label>
                                <x-jet-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="ops_no">{{ __('OPS Number') }}</label>
                                <x-jet-input id="ops_no" class="block mt-1 w-full" type="text" name="ops_no" :value="old('ops_no')" required />
                            </div>
                            <div class="mt-4 intro-y">
                                <label class="block font-medium text-sm text-white" for="or_no">{{ __('OR Number') }}</label>
                                <x-jet-input id="or_no" class="block mt-1 w-full" type="text" name="or_no" :value="old('or_no')" required />
                            </div>
                        </div>

                    </div>
                    <div class="mt-4 intro-y float-right">
                        <x-jet-button>
                            {{ __('Save') }}
                        </x-jet-button>
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

    @foreach($fsics as $data)
    L.marker([{{$data->latitude}}, {{$data->longitude}}], {icon: store}).addTo(map)
    .bindPopup('<h2>{{$data->establishment}}</h2><a class="text-xs">{{$data->address}}</a>')
    .openPopup();
    @endforeach
</script>

<script>
    function onlyNumberInput()
    {
        var key = event.which || event.keyCode;
        if (key && (key <= 47 || key >= 58) && key != 8) {
            event.preventDefault();
        }
    }

    $(function(){
        $("[name=ops_no]").keypress( onlyNumberInput );
        $("[name=or_no]").keypress( onlyNumberInput );
        $("[name=contact]").keypress( onlyNumberInput );
    })
</script>
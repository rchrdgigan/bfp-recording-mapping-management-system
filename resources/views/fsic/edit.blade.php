@section('title')
Edit FSIC
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Update FSIC Transaction') }}
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
        <form action="{{route('fsic.update',$fsic_trans->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="pos grid grid-cols-12 gap-5 mt-5">
                <!-- BEGIN: Post Content -->
                <div class="col-span-12 lg:col-span-4">
                    <div class="post intro-y overflow-hidden box">
                        <div class="post__content tab-content">
                            <div class="tab-content__pane p-5 active" id="content">
                            <h1 class="text-lg font-semibold text-center">Information</h1>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="fsic_no" value="{{ __('FSIC No.') }}" />
                                    <x-jet-input id="fsic_no" class="block mt-1 w-full text-xs" type="text" name="fsic_no" :value="old('fsic_no')" value="{{$fsic_trans->fsic->fsic_no}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="estab" value="{{ __('Name of Establishment') }}" />
                                    <x-jet-input id="estab" class="block mt-1 w-full text-xs" type="text" name="establishment" :value="old('establishment')" value="{{$fsic_trans->fsic->establishment}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="owner" value="{{ __('Name of Owner') }}" />
                                    <x-jet-input id="owner" class="block mt-1 w-full text-xs" type="text" name="owner" :value="old('owner')" value="{{$fsic_trans->fsic->owner}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="business_types" value="{{ __('Business Types') }}" />
                                    <x-jet-input id="business_types" class="block mt-1 w-full text-xs" type="text" name="business_types" :value="old('business_types')" value="{{$fsic_trans->fsic->business_type}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="contact" value="{{ __('Contact Number') }}" />
                                    <x-jet-input id="contact" class="block mt-1 w-full text-xs" type="text" name="contact" :value="old('contact')" value="{{$fsic_trans->fsic->contact}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="address" value="{{ __('Address') }}" />
                                    <x-jet-input id="address" class="block mt-1 w-full text-xs" type="text" name="address" :value="old('address')" value="{{$fsic_trans->fsic->address}}" required autofocus />
                                </div>
                                <div class="flex intro-y gap-2">
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                                        <x-jet-input id="valid_from" class="block mt-1 w-full text-xs" type="date" name="valid_from" :value="old('valid_from')" value="{{$fsic_trans->valid_for}}" required autofocus />
                                    </div>
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                                        <x-jet-input id="valid_to" class="block mt-1 w-full text-xs" type="date" name="valid_to" :value="old('valid_to')" value="{{$fsic_trans->valid_until}}" required autofocus />
                                    </div>
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                                    <x-jet-input id="amount" class="block mt-1 w-full text-xs" type="text" name="amount" :value="old('amount')" value="{{$fsic_trans->amount}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                                    <x-jet-input id="ops_no" class="block mt-1 w-full text-xs" type="text" name="ops_no" :value="old('ops_no')" value="{{$fsic_trans->ops_no}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                                    <x-jet-input id="or_no" class="block mt-1 w-full text-xs" type="text" name="or_no" :value="old('or_no')" value="{{$fsic_trans->or_no}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-button>
                                        {{ __('Update') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Post Content -->

                <!-- BEGIN: Road Map -->
                <div class="col-span-12 lg:col-span-8">
                    <div class="intro-y box p-10">
                        <h1 class="text-lg font-semibold text-center">Map Setting</h1>
                        <div style="height:500px;">
                            <x-map/>
                        </div>
                        <!-- Render Map -->
                        <div class="flex gap-2">
                            <x-jet-input id="lat" class="block mt-1 col-6 w-full text-xs" type="text" name="lat" :value="old('lat')" value="{{$fsic_trans->fsic->latitude}}" readonly autofocus placeholder="Click the map to auto generated lat or latitude" />
                            <x-jet-input id="lng" class="block mt-1 col-6 w-full text-xs" type="text" name="lng" :value="old('lng')" value="{{$fsic_trans->fsic->longitude}}" readonly autofocus placeholder="Click the map to auto generated lng or longitude" />
                        </div>
                    </div>
                </div>
                <!-- END: Road Map -->
            </div>
        </form>
    </div>
  </div>
</x-app-layout>

<script src="{{asset('dist/js/map.js')}}"></script>
<script>
    //If Deafault location is empty show the set location popup!
    var popup = L.popup()
        .setLatLng([12.6999972, 124.0333332])
        .setContent("Set location!")
        .openOn(map);

    //Get here the long & lati
    function onMapClick(e) {
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }
    map.on('click', onMapClick);

    //Deafault location
    L.marker([{{$fsic_trans->fsic->latitude}}, {{$fsic_trans->fsic->longitude}}]).addTo(map)
    .bindPopup('<h2>{{$fsic_trans->fsic->establishment}}</h2><a class="text-xs">{{$fsic_trans->fsic->address}}</a>')
    .openPopup();
</script>

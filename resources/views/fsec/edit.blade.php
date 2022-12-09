@section('title')
Edit FSEC
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Update FSEC Transaction') }}
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
        <form action="{{route('fsec.update',$fsec_trans->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="pos grid grid-cols-12 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4">
                    <div class="post intro-y overflow-hidden box">
                        <div class="post__content tab-content">
                            <div class="tab-content__pane p-5 active" id="content">
                            <h1 class="text-lg font-semibold text-center">Information</h1>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="fsec_no" value="{{ __('FSEC No.') }}" />
                                    <x-jet-input id="fsec_no" class="block mt-1 w-full text-xs" type="text" name="fsec_no" :value="old('fsec_no')" value="{{$fsec_trans->fsec->fsec_no}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="estab" value="{{ __('Name of Project') }}" />
                                    <x-jet-input id="estab" class="block mt-1 w-full text-xs" type="text" name="project" :value="old('project')" value="{{$fsec_trans->fsec->establishment}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="owner" value="{{ __('Name of Owner') }}" />
                                    <x-jet-input id="owner" class="block mt-1 w-full text-xs" type="text" name="owner" :value="old('owner')" value="{{$fsec_trans->fsec->owner}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="contact" value="{{ __('Contact Number') }}" />
                                    <x-jet-input id="contact" class="block mt-1 w-full text-xs" type="text" name="contact" :value="old('contact')" value="{{$fsec_trans->fsec->contact}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="address" value="{{ __('Address') }}" />
                                    <x-select-location />
                                </div>
                                <div class="flex intro-y gap-2">
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                                        <x-jet-input id="valid_from" class="block mt-1 w-full text-xs" type="date" name="valid_from" :value="old('valid_from')" value="{{$fsec_trans->valid_for}}" required autofocus />
                                    </div>
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                                        <x-jet-input id="valid_to" class="block mt-1 w-full text-xs" type="date" name="valid_to" :value="old('valid_to')" value="{{$fsec_trans->valid_until}}" required autofocus />
                                    </div>
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                                    <x-jet-input id="amount" class="block mt-1 w-full text-xs" type="text" name="amount" :value="old('amount')" value="{{$fsec_trans->amount}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                                    <x-jet-input id="ops_no" class="block mt-1 w-full text-xs" type="text" name="ops_no" :value="old('ops_no')" value="{{$fsec_trans->ops_no}}" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                                    <x-jet-input id="or_no" class="block mt-1 w-full text-xs" type="text" name="or_no" :value="old('or_no')" value="{{$fsec_trans->or_no}}" required autofocus />
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

                <div class="col-span-12 lg:col-span-8">
                    <div class="intro-y box p-10">
                        <h1 class="text-lg font-semibold text-center">Map Setting</h1>
                        <div style="height:500px;">
                            <x-map/>
                        </div>
                        <!-- Render Map -->
                        <div class="flex gap-2">
                            <x-jet-input id="lat" class="block mt-1 col-6 w-full text-xs" type="text" name="lat" :value="old('lat')" value="{{$fsec_trans->fsec->latitude}}" readonly autofocus placeholder="Click the map to auto generated lat or latitude" />
                            <x-jet-input id="lng" class="block mt-1 col-6 w-full text-xs" type="text" name="lng" :value="old('lng')" value="{{$fsec_trans->fsec->longitude}}" readonly autofocus placeholder="Click the map to auto generated lng or longitude" />
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
        .setLatLng([12.6999972, 124.0333332])
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

    L.marker([{{$fsec_trans->fsec->latitude}}, {{$fsec_trans->fsec->longitude}}], {icon: office}).addTo(map)
    .bindPopup('<h2>{{$fsec_trans->fsec->establishment}}</h2><a class="text-xs">{{$fsec_trans->fsec->address}}</a>')
    .openPopup();
</script>

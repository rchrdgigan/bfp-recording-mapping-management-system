@section('title')
FSIC Renewal
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Renewal FSIC') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('fsic.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>

        <x-jet-validation-errors class="mb-4 mt-5" />

        @if (session('message'))
            <div class="intro-y mt-5 flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>{{ session('message') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div role="alert">
                <div class="intro-y bg-red-500 text-white font-bold rounded-t px-4 py-2 mt-5">
                    Failed to Save
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <form action="{{route('fsic.renew')}}" method="post">
            @csrf
            <div class="flex mt-5 max-w-4xl mx-auto">
                <!-- BEGIN: Post Info -->
                <div class="w-full">
                    <div class="post intro-y overflow-hidden box">
                        <div class="post__content tab-content">
                            <div class="tab-content__pane p-5 active" id="content">
                            <h1 class="text-lg font-semibold text-center">Renewal Information</h1>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="fsic_no" value="{{ __('FSIC No.') }}" />
                                    <x-jet-input id="fsic_no" class="block mt-1 w-full text-xs" type="text" name="fsic_no" :value="old('fsic_no')" required autofocus />
                                </div>
                                <div class="flex intro-y gap-2">
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                                        <x-jet-input id="valid_from" class="block mt-1 w-full text-xs" type="date" name="valid_from" :value="old('valid_from')" required autofocus />
                                    </div>
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                                        <x-jet-input id="valid_to" class="block mt-1 w-full text-xs" type="date" name="valid_to" :value="old('valid_to')" required autofocus />
                                    </div>
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                                    <x-jet-input id="amount" class="block mt-1 w-full text-xs" type="text" name="amount" :value="old('amount')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                                    <x-jet-input id="ops_no" class="block mt-1 w-full text-xs" type="text" name="ops_no" :value="old('ops_no')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                                    <x-jet-input id="or_no" class="block mt-1 w-full text-xs" type="text" name="or_no" :value="old('or_no')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-button>
                                        {{ __('Save') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Post Content -->
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
    @foreach($fsics as $data)
    L.marker([{{$data->latitude}}, {{$data->longitude}}]).addTo(map)
    .bindPopup('<h2>{{$data->establishment}}</h2><a class="text-xs">{{$data->address}}</a>')
    .openPopup();
    @endforeach
</script>

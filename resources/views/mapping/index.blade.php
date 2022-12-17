@section('title')
Location Mapping
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Location Mapping') }}
      </h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="pos grid grid-cols-12 gap-5 mt-5">
            <div class="col-span-12">
                <div class="intro-y box p-10">
                    <h1 class="text-lg font-semibold text-center">Road Map</h1>

                    <div class="mt-4 ml-auto w-full">
                        <form method="get">
                            
                            <div class="w-full flex items-center relative">
                                <x-jet-input id="search" class="text-sm border border-gray-400 rounded-lg w-full px-10" type="text" name="search" :value="old('search')" value="{{request('search')}}" placeholder="Search FSIC Number, FSEC Number, Establishment or Owner" autofocus />
                                <i class="text-gray-600 fa fa-search fa-lg absolute ml-3" aria-hidden="true"></i>
                            </div>

                            <div class="w-full flex mt-2">
                                <div class="w-full flex">
                                    <select class="input w-full text-sm border border-gray-400" name="location" id="tabulator-html-filter-field">
                                        @if(request('location'))
                                            <option value="{{request('location')}}">{{request('location')}}</option>
                                        @endif
                                        <option value="">--- Location ---</option>
                                        <option value="Tabon-tabon">Tabon-tabon</option>
                                        <option value="San Agustin">San Agustin</option>
                                        <option value="San Juan">San Juan</option>
                                        <option value="Bacolod">Bacolod</option>
                                        <option value="San Julian">San Julian</option>
                                        <option value="San Pedro">San Pedro</option>
                                    </select>
                                </div>
                                <div class="w-full flex ml-2">
                                    <x-select-status/>
                                </div>
                                <button type="submit" class="text-center bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 ml-1 rounded-md">
                                    Go
                                </button>
                                @if(request('search') || request('status') || request('location'))
                                <a href="{{route('map.index')}}" class="text-center bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 ml-1 rounded-md">
                                    <i class="fa fa-close fa-lg" aria-hidden="true"></i>
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                 
                    <div style="height:500px;" class="mt-4">
                        <x-map/>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</x-app-layout>
<script src="{{asset('dist/js/map.js')}}"></script>
<script>
    @foreach($fsec_trans as $data_fsec)
    L.marker([{{$data_fsec->fsec->latitude}}, {{$data_fsec->fsec->longitude}}], {icon: office}).addTo(map)
    .bindPopup('<h2>{{$data_fsec->fsec->establishment}}</h2><a class="text-xs">{{$data_fsec->fsec->address}}</a>')
    .openPopup();
    @endforeach

    @foreach($fsic_trans as $data_fsic)
    L.marker([{{$data_fsic->fsic->latitude}}, {{$data_fsic->fsic->longitude}}], {icon: store}).addTo(map)
    .bindPopup('<h2>{{$data_fsic->fsic->establishment}}</h2><a class="text-xs">{{$data_fsic->fsic->address}}</a>')
    .openPopup();
    @endforeach
</script>

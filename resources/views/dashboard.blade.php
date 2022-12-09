@section('title')
Dashboard
@endsection
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <div class="w-full">
                    <h1 class="text-xl text-center mb-5 font-semibold">Quick Access</h1>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <div class="grid grid-cols-1">

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white hover:bg-blue-100">
                                <div class="p-5 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                                    <div class="flex items-center">
                                        <img src="{{asset('image/FSIC.PNG')}}" width="100px">
                                        <div class="ml-4 text-lg leading-7 font-semibold">Fire Safety Inspection Certificate</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold" id="count_fsic">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsec.index')}}" class="text-gray-900 dark:text-white hover:bg-blue-100">
                                <div class="p-5 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <img src="{{asset('image/FSEC.PNG')}}" width="110px">
                                        <div class="ml-4 text-lg leading-7 font-semibold">Fire Safety Evaluation Clearance</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold" id="count_fsec">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white hover:bg-blue-100">
                                <div class="p-5 border-t border-gray-200 dark:border-gray-700 md:border-l">
                                    <div class="flex items-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Map-icon.svg" width="40">
                                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Location Mapping</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold" id="count_location">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white hover:bg-blue-100">
                                <div class="p-5 border-t border-gray-200 dark:border-gray-700 md:border-l">
                                    <div class="flex items-center">
                                        <i class="text-green-500 fa fa-comment-sms fa-3x"></i>
                                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">SMS Notification</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold">0</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full p-10 lg:p-0">
                    <h1 class="text-xl text-center mb-5 font-semibold">Road Map</h1>

                    <div style="height:500px;">
                        <x-map/>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="{{asset('dist/js/map.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        function counter(id, start, end, duration) {
        let obj = document.getElementById(id),
        current = start,
        range = end - start,
        increment = end > start ? 1 : -1,
        step = Math.abs(Math.floor(duration / range)),
        timer = setInterval(() => {
            current += increment;
            obj.textContent = current;
            if (current == end) {
            clearInterval(timer);
            }
        }, step);
        }
        counter("count_fsic", -1, {{$fsic->count()}}, 1000);
        counter("count_fsec", -1, {{$fsec->count()}}, 1000);
        counter("count_location", -1, {{$fsec->count() + $fsic->count()}}, 1000);
    });
    
    @foreach($fsec as $data_fsec)
    L.marker([{{$data_fsec->latitude}}, {{$data_fsec->longitude}}], {icon: office}).addTo(map)
    .bindPopup('<h2>{{$data_fsec->establishment}}</h2><a class="text-xs">{{$data_fsec->address}}</a>')
    .openPopup();
    @endforeach

    @foreach($fsic as $data_fsic)
    L.marker([{{$data_fsic->latitude}}, {{$data_fsic->longitude}}], {icon: store}).addTo(map)
    .bindPopup('<h2>{{$data_fsic->establishment}}</h2><a class="text-xs">{{$data_fsic->address}}</a>')
    .openPopup();
    @endforeach
</script>
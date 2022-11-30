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
                    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <div class="grid grid-cols-1">

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white">
                                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                                    <div class="flex items-center">
                                        <i class="fa fa-building-shield fa-2x"></i>
                                        <div class="ml-4 text-lg leading-7 font-semibold">Fire Safety Inspection Certificate</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white">
                                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <i class="fa fa-certificate fa-2x"></i>
                                        <div class="ml-4 text-lg leading-7 font-semibold">Fire Safety Evaluation Clearance</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white">
                                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                                    <div class="flex items-center">
                                        <i class="fa-solid fa-map-location-dot fa-2x"></i>
                                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Mapping</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold">0</div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{route('fsic.index')}}" class="text-gray-900 dark:text-white">
                                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                                    <div class="flex items-center">
                                        <i class="fa fa-comment-sms fa-2x"></i>
                                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">SMS Notification</div>
                                        <div class="ml-auto text-xl leading-7 font-semibold">0</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full p-10 lg:p-0">
                    <div class="mt-5" style="height:500px;">
                        @include('map')
                    </div>
                </div>
              
            </div>
            
        </div>
    </div>
</x-app-layout>
<script src="{{asset('dist/js/map.js')}}"></script>


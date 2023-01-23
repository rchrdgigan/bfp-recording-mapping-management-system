@section('title')
View FSIC
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-bold text-xl text-gray-800 leading-tight">
          {{ __('View FSIC Transaction') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(isset($_GET['status']))
        <a href="{{route('fsic.history')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        @else
        <a href="{{route('fsic.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        @endif
        <div class="pos grid grid-cols-12 gap-5 mt-5">
            <div class="col-span-12 lg:col-span-4 text-center text-white">
                <h1 class="text-lg font-bold">Information</h1>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('FSIC No.') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Name of Establishment') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic->establishment}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Name of Owner') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic->owner}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Business Types') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic->business_type}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Contact Number') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic->contact}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Address') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->fsic->address}}</label>
                </div>

                <hr class="mt-4 intro-y">

                <div class="flex intro-y gap-2">
                    <div class="mt-4 col-span-6 mx-auto">
                        <label class="font-medium">{{ __('Valid For') }}</label><br>
                        {{Carbon\Carbon::parse($fsic_trans->for)->format('M d, Y')}}
                    </div>
                    <div class="mt-4 col-span-6 mx-auto">
                        <label class="font-medium">{{ __('Valid Until') }}</label><br>
                        <label class="font-medium">{{Carbon\Carbon::parse($fsic_trans->valid_until)->format('M d, Y')}}</label>
                    </div>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Amount') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->amount}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('OPS Number') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->ops_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('OR Number') }}</label><br>
                    <label class="font-medium">{{$fsic_trans->or_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    @if($fsic_trans->valid_until <= Carbon\Carbon::now()->addDays(6)->format('Y-m-d'))
                        @if($fsic_trans->status <> 1)
                            <a class="bg-teal-500 hover:bg-teal-700 text-white py-2 px-4 ml-2 rounded-md">
                                Message
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8">
                <div class="intro-y box p-10">
                    <h1 class="text-lg font-semibold text-center">Road Map</h1>
                    <div style="height:500px;">
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
    L.marker([{{$fsic_trans->fsic->latitude}}, {{$fsic_trans->fsic->longitude}}], {icon: store}).addTo(map)
    .bindPopup('<h2>{{$fsic_trans->fsic->establishment}}</h2><a class="text-xs">{{$fsic_trans->fsic->address}}</a>')
    .openPopup();
</script>

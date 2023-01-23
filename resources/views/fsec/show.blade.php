@section('title')
View FSEC
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('View FSEC Transaction') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(isset($_GET['status']))
        <a href="{{route('fsec.history')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        @else
        <a href="{{route('fsec.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        @endif
        <div class="pos grid grid-cols-12 gap-5 mt-5">
            <div class="col-span-12 lg:col-span-4 text-white text-center">
                <h1 class="text-lg font-semibold">Information</h1>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('FSEC No.') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->fsec_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Name of Project') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->fsec->establishment}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Name of Owner') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->fsec->owner}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Contact Number') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->fsec->contact}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Address') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->fsec->address}}</label>
                </div>

                <hr class="mt-4 intro-y">

                <div class="flex intro-y gap-2">
                    <div class="mt-4 col-span-6 mx-auto">
                        <label class="font-medium">{{ __('Valid For') }}</label><br>
                        <label class="font-medium">{{Carbon\Carbon::parse($fsec_trans->for)->format('M d, Y')}}</label>
                    </div>
                    <div class="mt-4 col-span-6 mx-auto">
                        <label class="font-medium">{{ __('Valid Until') }}</label><br>
                        <label class="font-medium">{{Carbon\Carbon::parse($fsec_trans->valid_until)->format('M d, Y')}}</label>
                    </div>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('Amount') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->amount}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('OPS Number') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->ops_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    <label class="font-medium">{{ __('OR Number') }}</label><br>
                    <label class="font-medium">{{$fsec_trans->or_no}}</label>
                </div>
                <div class="mt-4 intro-y">
                    @if($fsec_trans->valid_until <= Carbon\Carbon::now()->addDays(6)->format('Y-m-d'))
                        @if($fsec_trans->status <> 1)
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
    L.marker([{{$fsec_trans->fsec->latitude}}, {{$fsec_trans->fsec->longitude}}], {icon: office}).addTo(map)
    .bindPopup('<h2>{{$fsec_trans->fsec->establishment}}</h2><a class="text-xs">{{$fsec_trans->fsec->address}}</a>')
    .openPopup();
</script>

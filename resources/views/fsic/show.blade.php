<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Show FSIC') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('fsic.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            Back
        </a>

        <div class="pos grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="col-span-12 lg:col-span-4 text-center">
                <h1 class="text-lg font-semibold">Information</h1>
                <div class="mt-4 intro-y">
                    <x-jet-label for="fsic_no" value="{{ __('FSIC No.') }}" />
                    {{$fsic_trans->fsic->fsic_no}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="estab" value="{{ __('Name of Establishment') }}" />
                    {{$fsic_trans->fsic->establishment}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="owner" value="{{ __('Name of Owner') }}" />
                    {{$fsic_trans->fsic->owner}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="business_types" value="{{ __('Business Types') }}" />
                    {{$fsic_trans->fsic->business_type}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="contact" value="{{ __('Contact Number') }}" />
                    {{$fsic_trans->fsic->contact}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    {{$fsic_trans->fsic->address}}
                </div>
                <div class="flex intro-y gap-2">
                    <div class="mt-4 col-span-6 mx-auto">
                        <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                        {{Carbon\Carbon::parse($fsic_trans->for)->format('M d, Y')}}
                    </div>
                    <div class="mt-4 col-span-6 mx-auto">
                        <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                        {{Carbon\Carbon::parse($fsic_trans->valid_until)->format('M d, Y')}}
                    </div>
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                    {{$fsic_trans->amount}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                    {{$fsic_trans->ops_no}}
                </div>
                <div class="mt-4 intro-y">
                    <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                    {{$fsic_trans->or_no}}
                </div>
            </div>
            <!-- END: Post Content -->

            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-8">
                <div class="intro-y box p-10">
                    <h1 class="text-lg font-semibold text-center">Map Setting</h1>
                    <div style="height:500px;">
                        @include('fsic.map')
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>
    </div>
  </div>
</x-app-layout>
<script src="{{asset('dist/js/map.js')}}"></script>
<script>
    //Deafault location
    L.marker([{{$fsic_trans->fsic->latitude}}, {{$fsic_trans->fsic->longitude}}]).addTo(map)
    .bindPopup('<h2>{{$fsic_trans->fsic->establishment}}</h2><a class="text-xs">{{$fsic_trans->fsic->address}}</a>')
    .openPopup();
</script>

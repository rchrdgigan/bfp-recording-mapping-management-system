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
        <x-success/>
        <x-error/>
        <form action="{{route('fsic.renew')}}" method="post">
            @csrf
            <div class="flex mt-5 max-w-4xl mx-auto">
                <div class="w-full">
                    <div class="post intro-y overflow-hidden box">
                        <div class="post__content tab-content">
                            <div class="tab-content__pane p-5 active" id="content">
                                <h1 class="text-lg font-bold text-center">Renewal Information</h1>
                                <input type="hidden" name="fsic_id" value="{{$fsics->id}}">
                                <div class="flex text-center">
                                    <div class="mt-4 w-full intro-y">
                                        <x-jet-label for="fsic_no" value="Name of Owner: " />{{$fsics->owner}}
                                    </div>
                                    <div class="mt-4 w-full intro-y">
                                        <x-jet-label for="fsic_no" value="Name of Project: " />{{$fsics->establishment}}
                                    </div>
                                </div>
                                <!-- <div class="mt-4 intro-y">
                                    <x-jet-label for="fsic_no" value="{{ __('FSIC No.') }}" />
                                    <x-jet-input id="fsic_no" class="block mt-1 w-full" type="text" name="fsic_no" :value="old('fsic_no')" required autofocus />
                                </div> -->
                                <div class="grid grid-cols-12 intro-y gap-2">
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_from" value="{{ __('Valid For') }}" />
                                        <x-jet-input id="valid_from" class="block mt-1 w-full" type="date" name="valid_from" :value="old('valid_from')" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required autofocus />
                                    </div>
                                    <div class="mt-4 col-span-6">
                                        <x-jet-label for="valid_to" value="{{ __('Valid Until') }}" />
                                        <x-jet-input id="valid_to" class="block mt-1 w-full" type="date" name="valid_to" :value="old('valid_to')" value="{{Carbon\Carbon::now()->addYear()->format('Y-m-d')}}" required autofocus />
                                    </div>
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                                    <x-jet-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="ops_no" value="{{ __('OPS Number') }}" />
                                    <x-jet-input id="ops_no" class="block mt-1 w-full" type="text" name="ops_no" :value="old('ops_no')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-label for="or_no" value="{{ __('OR Number') }}" />
                                    <x-jet-input id="or_no" class="block mt-1 w-full" type="text" name="or_no" :value="old('or_no')" required autofocus />
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-button>
                                        {{ __('Renew') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</x-app-layout>

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
    })
</script>
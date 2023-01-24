@section('title')
Message Client
@endsection

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Message Client') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{route('sms.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 ml-3 rounded-md">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
        <x-jet-validation-errors class="mb-4 mt-5" />
        <x-success/>
        <x-error/>
        <form action="{{route('sms.store')}}" method="post">
            @csrf
            <div class="flex mt-5 max-w-4xl mx-auto">
                <div class="w-full">
                    <div class="post intro-y overflow-hidden box">
                        <div class="post__content tab-content">
                            <div class="tab-content__pane p-5 active" id="content">
                            <h1 class="text-lg font-semibold text-center">Message Information</h1>
                                <div class="mt-4 intro-y">
                                    <label class="block font-medium text-md" for="r_no">{{ __('Recipient') }}</label>
                                    <select class="select2 block mt-1 w-full input border-gray-300" name="recipient" required id="r_no">
                                    @foreach($fsec as $data_fsec)
                                        <option value="{{$data_fsec->owner}} | {{$data_fsec->contact}} | FSEC">{{$data_fsec->owner}} | {{$data_fsec->contact}} | FSEC</option>
                                    @endforeach
                                    @foreach($fsic as $data_fsic)
                                        <option value="{{$data_fsic->owner}} | {{$data_fsic->contact}} | FSIC">{{$data_fsic->owner}} | {{$data_fsic->contact}} | FSIC</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="mt-4 intro-y">
                                    <label class="block font-medium text-md" for="message">{{ __('Text Message') }}</label>
                                    <textarea name="message" cols="30" rows="10" id="message" class="block mt-1 w-full input border-gray-300" required></textarea>
                                </div>
                                <div class="mt-4 intro-y">
                                    <x-jet-button>
                                        {{ __('Send') }}
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
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

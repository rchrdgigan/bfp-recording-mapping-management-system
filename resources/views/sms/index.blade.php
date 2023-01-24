@section('title')
SMS Management
@endsection
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-bold text-xl text-gray-900 leading-tight">
          {{ __('SMS Management') }}
      </h2>
  </x-slot>
  
  <div class="py-12 p-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <x-success/>
      <x-error/>
      <div class="flex mt-5 gap-2">
        <a href="{{route('sms.create')}}" class="text-center bg-blue-400 hover:bg-blue-600 text-white py-2 px-4 rounded-md w-40">
          <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Create
        </a>
        <div class="ml-auto w-full">
          <form method="get">
            
            <div class="w-full flex items-center relative">
              <x-jet-input id="search" class="border border-gray-400 rounded-lg w-full px-10" type="text" name="search" :value="old('search')" value="{{request('search')}}" placeholder="Search message or number of recipient" autofocus />
              <i class="text-gray-600 fa fa-search fa-lg absolute ml-3" aria-hidden="true"></i>
              <button type="submit" class="text-center bg-blue-400 hover:bg-blue-600 text-white py-2 px-4 ml-1 rounded-md">
                Go
              </button>
              @if(request('search'))
              <a href="{{route('sms.index')}}" class="text-center bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 ml-1 rounded-md">
                <i class="fa fa-close fa-lg" aria-hidden="true"></i>
              </a>
              @endif
            </div>
          </form>
        </div>
      </div>
      <section class="container mx-auto mt-5 mb-3">
        <div class="w-full overflow-hidden rounded-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full table table-report">
              <thead>
                <tr class="font-bold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                  <td class="px-4 py-3">Date</td>
                  <td class="px-4 py-3">Bussiness Owner</td>
                  <td class="px-4 py-3">Contact Number</td>
                  <td class="px-4 py-3">Messages</td>
                  <td class="px-4 py-3">Status</td>
                  <td class="px-4 py-3">Action</td>
                </tr>
              </thead>
              <tbody class="bg-white">
                @forelse($sms as $data)
                <tr class="font-medium text-gray-900">
                  <td class="px-4 py-3 ">{{Carbon\Carbon::parse($data->created_at)->format('M d, Y')}}</td>
                  <td class="px-4 py-3 ">{{$data->owner}}</td>
                  <td class="px-4 py-3 ">{{$data->contact}}</td>
                  <td class="px-4 py-3 ">{{$data->message}}</td>
                  <td class="px-4 py-3 ">{{$data->status}}</td>
                  <td>
                    <div class="flex gap-1">
                        @livewire('sms-delete', ['sms_del' => $data], key($data->id))
                    </div>
                  </td>
                </tr>
                @empty
                <div class="mt-5 flex w-full items-center bg-orange-400 text-white font-bold px-4 py-3" role="alert">
                  <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                  <p>No data available in table</p>
                </div>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </section>
      {{$sms->links()}}
    </div>
  </div>

</x-app-layout>
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
      <div class="flex gap-2">
        <a href="{{route('sms.create')}}" class="text-center bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md w-40">
          <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Create
        </a>
        <div class="ml-auto w-full">
          <form method="get">
            
            <div class="w-full flex items-center relative">
              <x-jet-input id="search" class="border border-gray-400 rounded-lg w-full px-10" type="text" name="search" :value="old('search')" value="{{request('search')}}" placeholder="Search message or number of recipient" autofocus />
              <i class="text-gray-600 fa fa-search fa-lg absolute ml-3" aria-hidden="true"></i>
              <button type="submit" class="text-center bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 ml-1 rounded-md">
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
                  <td class="px-4 py-3">Recipient Number</td>
                  <td class="px-4 py-3">Messages</td>
                  <td class="px-4 py-3">Status</td>
                  <td class="px-4 py-3">Action</td>
                </tr>
              </thead>
              <tbody class="bg-white">
               
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>

</x-app-layout>
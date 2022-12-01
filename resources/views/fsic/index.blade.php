@section('title')
FSIC Management
@endsection
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('FSIC Transaction Management') }}
      </h2>
  </x-slot>

  <div class="py-12 p-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex col-span-12 gap-2">
        <a href="{{route('fsic.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
        <i class="fa fa-plus" aria-hidden="true"></i> Add New
        </a>
        <a href="{{route('fsic.renewal')}}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
        <i class="fa fa-check-circle" aria-hidden="true"></i> Renewal
        </a>  
        <div class="ml-auto w-60">
          <x-jet-input id="search" class="block mt-1 w-full text-xs" type="text" name="search" :value="old('search')" placeholder="Search" autofocus />
        </div>
      </div>
      <!-- component -->
      <section class="container mx-auto mt-5">
        <div class="w-full overflow-hidden rounded-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full table table-report">
              <thead>
                <tr class="text-md font-bold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                  <th class="text-xs px-4 py-3">Date</th>
                  <th class="text-xs px-4 py-3">QR No.</th>
                  <th class="text-xs px-4 py-3">FSIC No.</th>
                  <th class="text-xs px-4 py-3">Establishment</th>
                  <th class="text-xs px-4 py-3">Owner</th>
                  <th class="text-xs px-4 py-3">Address</th>
                  <th class="text-xs px-4 py-3">Status</th>
                  <th class="text-xs px-4 py-3">Action</th>
                </tr>
              </thead>
              <tbody class="bg-white">
                @forelse($fsic_trans as $data)
                <tr class="text-gray-700">
                  <td class="text-xs px-4 py-3 text-ms ">{{Carbon\Carbon::parse($data->created_at)->format('M d, Y')}}</td>
                  <td class="text-xs px-4 py-3 text-ms ">{{$data->or_no}}</td>
                  <td class="text-xs px-4 py-3 text-ms ">{{$data->fsic->fsic_no}}</td>
                  <td class="text-xs px-4 py-3 text-ms ">{{$data->fsic->establishment}}</td>
                  <td class="text-xs px-4 py-3 text-ms ">{{$data->fsic->owner}}</td>
                  <td class="text-xs px-4 py-3 text-ms ">{{$data->fsic->address}}</td>
                  <td class="text-xs px-4 py-3 text-xs">
                    <span class="px-2 py-1  leading-tight {{($data->valid_until > Carbon\Carbon::now()->format('Y-m-d')) ? ($data->status == 0) ? 'text-green-700 bg-green-100':'text-gray-700 bg-gray-100':($data->status == 1 ? 'text-gray-700 bg-gray-100':'text-orange-700 bg-orange-100')}}  rounded-sm">
                      {{($data->valid_until > Carbon\Carbon::now()->format('Y-m-d')) ? ($data->status == 0) ? 'New':'Oldest': ($data->status == 1 ? 'Oldest':'Expired')}}
                    </span>
                  </td>
                  <td>
                    <div class="flex gap-1">
                      <a href="{{route('fsic.show', $data->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </a> 
                      <a href="{{route('fsic.edit', $data->id)}}" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded-md">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                      </a>   
                      <a class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-md">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                      </a>   
                    </div>
                  </td>
                </tr>
                @empty
                <div class="mt-5 flex w-full items-center bg-orange-400 text-white text-sm font-bold px-4 py-3" role="alert">
                  <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                  <p>No data available in table</p>
                </div>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </section>

    </div>
  </div>

</x-app-layout>

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('FSIC Management') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <a href="{{route('fsic.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 ml-3 rounded-md">
        Create New
      </a>        
          
      <!-- component -->
      <section class="container mx-auto mt-5">
        <div class="w-full overflow-hidden rounded-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full table table-report">
              <thead>
                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
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
                @foreach($fsic_trans as $data)
                <tr class="text-gray-700">
                  <td class="text-xs px-4 py-3 text-ms font-semibold">{{$data->or_no}}</td>
                  <td class="text-xs px-4 py-3 text-ms font-semibold">{{$data->fsic->fsic_no}}</td>
                  <td class="text-xs px-4 py-3 text-ms font-semibold">{{$data->fsic->establishment}}</td>
                  <td class="text-xs px-4 py-3 text-ms font-semibold">{{$data->fsic->owner}}</td>
                  <td class="text-xs px-4 py-3 text-ms font-semibold">{{$data->fsic->address}}</td>
                  <td class="text-xs px-4 py-3 text-xs">
                    <span class="px-2 py-1 font-semibold leading-tight {{($data->valid_until > Carbon\Carbon::now()->format('Y-m-d')) ? ($data->status == 0) ? 'text-green-700 bg-green-100':'text-gray-700 bg-gray-100':'text-orange-700 bg-orange-100'}}  rounded-sm">
                      {{($data->valid_until > Carbon\Carbon::now()->format('Y-m-d')) ? ($data->status == 0) ? 'New':'Oldest':'Expired'}}
                    </span>
                  </td>
                  <td class="text-xs px-4 py-3 text-sm">
                    <div class="relative">
                      <x-jet-dropdown align="left" width="30">
                          <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                              <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                  Option
                                  <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                              </button>
                            </span>
                          </x-slot>
                          <x-slot name="content">
                            <div class="m-1">
                              @if($data->valid_until < Carbon\Carbon::now()->format('Y-m-d'))
                              <button class="bg-teal-500 hover:bg-teal-700 w-full mb-1 text-white py-2 px-4 rounded-md">
                                  Renew
                              </button>
                              @endif
                              <button class="bg-blue-500 hover:bg-blue-700 w-full mb-1 text-white py-2 px-4 rounded-md">
                                  View
                              </button> 
                              <button class="bg-green-500 hover:bg-green-700 w-full mb-1 text-white py-2 px-4 rounded-md">
                                  Edit
                              </button>   
                              <button class="bg-red-500 hover:bg-red-700 w-full text-white py-2 px-4 rounded-md">
                                  Delete
                              </button>   
                            </div>
                          </x-slot>
                        </x-jet-dropdown>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>

    </div>
  </div>

</x-app-layout>

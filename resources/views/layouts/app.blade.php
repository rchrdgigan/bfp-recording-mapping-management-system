<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
        <!-- Leaflet -->
        <link href="{{asset('image/bfp.png')}}" rel="shortcut icon">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('dist/css/app.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.addEventListener('swal:confirm', event => {
    Swal.fire({
        position: 'top-center',
        icon: 'warning',
        title: event.detail.title,
        text: event.detail.text,
        showCancelButton:  event.detail.showCancelButton,
        confirmButtonText: event.detail.confirmButtonText,
        denyButtonText: `Cancel`,
    }).then((result) => {
        if (result.isConfirmed) {
            if(event.detail.confirmButtonText == 'Ok'){
               
            }else{
                window.livewire.emit('delete', event.detail.id)
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Successfully Deleted!',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        }
    });
});
</script>

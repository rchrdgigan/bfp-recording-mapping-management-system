<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="{{asset('image/bfp.png')}}" rel="shortcut icon">
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <style>
        #background___img {
            background: linear-gradient( rgba(102, 0, 0, 0.4), rgba(0, 0, 102, 0.4) ), url('/image/background.jpg') no-repeat center center;
            background-size: cover;
            width: 100%;
        }
       
        @media only screen and (max-width: 600px) {
            #background___img {
                background: linear-gradient( rgba(102, 0, 0, 0.4), rgba(0, 0, 102, 0.4) ), url('/image/background.jpg') no-repeat center center;
                background-size: cover;
                position: absolute;
                width: 100%;
                height: 10%;
                bottom: 0;
            }
        }
    </style>
    <body>
        <div class="flex">
            <div class="font-sans text-gray-900 antialiased w-full">
                {{ $slot }}
            </div>
            <div id="background___img"></div>
        </div>
    </body>
</html>


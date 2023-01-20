<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background: linear-gradient( rgba(102, 0, 0, 0.4), rgba(0, 0, 102, 0.4) ), url('/image/background.jpg') no-repeat center center;background-size: cover;">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>

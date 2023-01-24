@if (session('error'))
    <div role="alert">
        <div class="intro-y bg-red-500 text-white font-bold rounded-t px-4 py-2 mt-5">
            Failed Alert
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif
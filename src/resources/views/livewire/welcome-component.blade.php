<div class="flex flex-col items-center justify-center py-8">
    <div class="flex flex-col items-center space-y-6 p-8 w-full sm:w-96">
        <h1 class="text-2xl font-semibold text-white">{{ $message }}</h1>

        <a href="{{ route('appointments.create') }}" class="mt-4 px-6 py-2 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 text-center">
            Creează o programare
        </a>
    </div>
</div>

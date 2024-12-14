<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8">
        <h1 class="text-3xl font-semibold text-gray-900 mb-6">Appointments</h1>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Service</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Appointment Type</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($appointments as $appointment)
                        <tr class="border-b border-gray-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $appointment->service->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $appointment->appointment_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $appointment->status == 'registered' ? 'bg-blue-100 text-blue-600' : ($appointment->status == 'processed' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right space-x-3">
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

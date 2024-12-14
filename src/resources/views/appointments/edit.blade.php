<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold text-white mb-6">Editează Programarea</h1>
        <div class="bg-white shadow-md rounded-lg p-6">

            @if ($appointment)
                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                    @csrf
                    @method('PUT')
                    @if($fromService)
                        <input type="hidden" name="from_service" value=1>
                    @endif

                    <div class="mb-4">
                        <label for="service_id" class="block text-gray-700 font-medium">Service</label>
                        <select name="service_id" id="service_id" 
                                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $service->id == $appointment->service_id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="vehicle_id" class="block text-gray-700 font-medium">Vehicul</label>
                        <select name="vehicle_id" id="vehicle_id"
                                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                            @foreach (auth()->user()->vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ $vehicle->id == $appointment->vehicle_id ? 'selected' : '' }}>
                                    {{ $vehicle->brand }} {{ $vehicle->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="appointment_type" class="block text-gray-700 font-medium">Tip Programare</label>
                        <select name="appointment_type" id="appointment_type"
                                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="ITP" {{ $appointment->appointment_type == 'ITP' ? 'selected' : '' }}>ITP</option>
                            <option value="Reparații" {{ $appointment->appointment_type == 'Reparații' ? 'selected' : '' }}>Reparații</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="appointment_time" class="block text-gray-700 font-medium">Data și Ora</label>
                        <input type="datetime-local" name="appointment_time" id="appointment_time"
                               value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d\TH:i') }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    </div>

                    <div class="mb-4">
                        <label for="observations" class="block text-gray-700 font-medium">Observații</label>
                        <textarea name="observations" id="observations" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                            {{ $appointment->observations }}
                        </textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-medium">Status</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="registered" {{ $appointment->status == 'registered' ? 'selected' : '' }}>Înregistrată</option>
                            <option value="processed" {{ $appointment->status == 'processed' ? 'selected' : '' }}>Procesată</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Finalizată</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Salvează Modificările
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#appointment_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minuteIncrement: 5,
        });
    });
</script>
<div class="p-6 bg-white rounded shadow-md">
    @if ($appointmentConfirmed)
        <div class="text-green-600 font-medium">
            Programarea a fost confirmată!
        </div>
    @else
        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Nume</label>
                <input type="text" wire:model="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200"
                    {{ auth()->check() ? 'readonly' : '' }}>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" wire:model="email" id="email"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200"
                    {{ auth()->check() ? 'readonly' : '' }}>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium">Telefon</label>
                <input type="text" wire:model="phone" id="phone"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                @error('phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 font-medium">Service</label>
                <select wire:model="service_id" id="service_id"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Selectează un service</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="vehicle_id" class="block text-gray-700 font-medium">Vehicul</label>
                <select wire:model="vehicle_id" id="vehicle_id"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Selectează un vehicul existent</option>
                    @foreach ($userVehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} {{ $vehicle->model }}</option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @if (!$vehicle_id)
                <div class="mb-4">
                    <label for="brand" class="block text-gray-700 font-medium">Marcă</label>
                    <input type="text" wire:model="brand" id="brand"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('brand')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="model" class="block text-gray-700 font-medium">Model</label>
                    <input type="text" wire:model="model" id="model"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('model')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="chassis_series" class="block text-gray-700 font-medium">Serie Șasiu</label>
                    <input type="text" wire:model="chassis_series" id="chassis_series"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('chassis_series')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="manufacture_year" class="block text-gray-700 font-medium">An Fabricație</label>
                    <input type="number" wire:model="manufacture_year" id="manufacture_year"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('manufacture_year')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="engine" class="block text-gray-700 font-medium">Motorizare</label>
                    <input type="text" wire:model="engine" id="engine"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('engine')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="mb-4">
                <label for="appointment_type" class="block text-gray-700 font-medium">Tip Programare</label>
                <select wire:model="appointment_type" id="appointment_type"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Selectează tipul</option>
                    <option value="ITP">ITP</option>
                    <option value="Reparații">Reparații</option>
                </select>
                @error('appointment_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="appointment_time" class="block text-gray-700 font-medium">Data și Ora</label>
                <input type="text" wire:model="appointment_time" id="appointment_time"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200"
                    placeholder="Selectează data și ora" />
                @error('appointment_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-4">
                <label for="observations" class="block text-gray-700 font-medium">Observații</label>
                <textarea wire:model="observations" id="observations" placeholder="Observații"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200"></textarea>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                Confirmă Programarea
            </button>
        </form>
    @endif
</div>

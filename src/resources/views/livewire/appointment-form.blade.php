<div>
    <form wire:submit.prevent="submit">
        <div>
            <label for="service_id">Service</label>
            <select wire:model="service_id" id="service_id">
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="appointment_type">Tip Programare</label>
            <select wire:model="appointment_type" id="appointment_type">
                <option value="ITP">ITP</option>
                <option value="Reparații">Reparații</option>
            </select>
        </div>

        <div>
            <label for="appointment_time">Data și Ora</label>
            <input type="datetime-local" wire:model="appointment_time">
        </div>

        <button type="submit">Programează</button>
    </form>
</div>

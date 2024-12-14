<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold text-white mb-6">Crează o Programare</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <livewire:forms.appointment-form />
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
<div class="p-6 bg-white shadow-md rounded-lg">    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto bg-gray-100 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-6 py-3 text-left text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-gray-600">Permisiuni</th>
                    <th class="px-6 py-3 text-left text-gray-600">Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            <span
                                class="inline-block px-3 py-1 rounded-full 
                                {{ $user->is_active == 1 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $user->is_active == 1 ? 'activ' : 'inactiv' }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <button wire:click="selectUser({{ $user->id }})"
                                class="text-blue-500 hover:text-blue-700 px-4 py-2 rounded-md">
                                Modifică Permisiuni
                            </button>
                            <button wire:click="toggleStatus({{ $user->id }})"
                                class="ml-2 px-4 py-2 rounded-md 
                                    {{ $user->is_active ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }} hover:bg-opacity-80">
                                {{ $user->is_active ? 'Dezactivează' : 'Activează' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    @if ($selectedUser)
        <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Permisiuni pentru {{ $selectedUser->email }}</h3>
            <form wire:submit.prevent="updatePermissions">
                <div class="space-y-4">
                    @foreach ($allPermissions as $permission)
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="permissions" value="{{ $permission->id }}"
                                id="permissions{{ $permission->id }}"
                                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <label for="permissions{{ $permission->id }}" class="ml-2 text-gray-700">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                        Salvează Permisiuni
                    </button>
                    <button type="button" wire:click="deselectUser"
                        class="w-full mt-2 bg-gray-500 text-white py-2 rounded-md hover:bg-gray-600">
                        Anulează
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

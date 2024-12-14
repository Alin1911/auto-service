<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class UserManagement extends Component
{
    use WithPagination;

    public $permissions = [];
    public $selectedUser = null;
    public $allPermissions = [];
    public $services = [];
    public $service_id = null;

    public function mount()
    {
        $this->services = Service::all();
        $this->allPermissions = Permission::all();
    }

    public function render()
    {
        $users = User::query()
            ->paginate(10);

        return view('livewire.user-management', compact('users'));
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);

        if ($this->selectedUser) {
            $this->permissions = $this->selectedUser->permissions->pluck('id')->toArray();
            $this->service_id = $this->selectedUser->service_id;
        }
    }

    public function updatePermissions()
    {
        if ($this->selectedUser) {
            $this->updateService();
            $permissions = Permission::whereIn('id', $this->permissions)->get();

            $this->selectedUser->syncPermissions($permissions);

            session()->flash('message', 'Permisiunile au fost actualizate!');

            $this->deselectUser();
        }
    }

    public function updateService()
    {
        if ($this->selectedUser) {
            $this->selectedUser->update(['service_id' => $this->service_id ? $this->service_id : null]);
        }
    }

    public function toggleStatus($userId)
    {
        $user = User::find($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        session()->flash('message', 'Statusul utilizatorului a fost schimbat!');
    }

    public function deselectUser()
    {
        $this->selectedUser = null;
        $this->permissions = [];
    }
}

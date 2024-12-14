<?php

namespace App\Livewire;

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

    public function mount()
    {
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

        $this->permissions = $this->selectedUser->permissions->pluck('id')->toArray();
    }

    public function updatePermissions()
    {
        if ($this->selectedUser) {
            $permissions = Permission::whereIn('id', $this->permissions)->get();
    
            $this->selectedUser->syncPermissions($permissions);
    
            session()->flash('message', 'Permisiunile au fost actualizate!');
    
            $this->deselectUser();
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

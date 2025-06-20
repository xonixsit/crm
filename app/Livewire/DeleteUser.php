<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DeleteUser extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function deleteUser()
    {
        $this->user->delete();

        session()->flash('message', 'User deleted successfully.');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.delete-user');
    }
}

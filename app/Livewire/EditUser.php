<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateUser()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('message', 'User updated successfully.');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.edit-user');
    }
}

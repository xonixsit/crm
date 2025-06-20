<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function viewUser(User $user)
    {
        return redirect()->route('users.show', $user);
    }

    public function editUser(User $user)
    {
        return redirect()->route('users.edit', $user);
    }

    public function deleteUser(User $user)
    {
        return redirect()->route('users.delete', $user);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->withCount('leads')
            ->paginate(10);

        return view('livewire.users-table', [
            'users' => $users,
        ]);
    }
}
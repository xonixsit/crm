<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AssignLeads extends Component
{

    public $users;
    public $selectedLeads = [];
    public $page = 1;
    public $leadType = '';
    public $leadTypes = '';
    public $selectedUser;
    public $searchLeads = '';
    public $selectedStatuses = ''; // Default selected statuses
    public $userSearch = '';
    public $selectAll = false;
    use WithPagination;

    public function mount()
    {
        $this->loadUsers();
    }



    public function loadUsers()
    {
        $this->users = User::all();
    }

    public function updatedSearchLeads()
    {
        $this->resetPage();
        $this->reset('selectedLeads', 'selectAll');
    }

    public function updatedSelectedStatuses()
    {
        $this->resetPage();
        $this->reset('selectedLeads', 'selectAll');
    }

    public function updatedUserSearch($value)
    {
        $this->userSearch = $value;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $query = Lead::query();

            if ($this->searchLeads) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->searchLeads . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchLeads . '%')
                        ->orWhere('company', 'like', '%' . $this->searchLeads . '%')
                        ->orWhere('email', 'like', '%' . $this->searchLeads . '%');
                });
            }

            if (!empty($this->selectedStatuses)) {
                $query->where('status', $this->selectedStatuses);
            }

            // ✅ Get ALL matching leads, not just paginated
            $this->selectedLeads = $query->pluck('id')->toArray();
        } else {
            $this->selectedLeads = [];
        }
    }

    public function assignLeads()
    {
        if (empty($this->selectedLeads) || empty($this->selectedUser)) {
            session()->flash('message', 'Please select leads and a user to assign.');
            return;
        }

        $user = User::find($this->selectedUser);

        if (!$user) {
            session()->flash('message', 'Selected user not found.');
            return;
        }

        foreach ($this->selectedLeads as $leadId) {
            $lead = Lead::find($leadId);
            if ($lead) {
                $lead->assigned_user_id = $user->id;
                $lead->save();
            }
        }

        $this->selectedLeads = [];
        $this->selectedUser = null;

        session()->flash('message', 'Leads assigned successfully!');
    }

    public function getStatusClass(string $status): string
    {
        switch ($status) {
            case 'yet_to_call':
                return 'bg-yellow-500 text-white';
            case 'new':
                return 'bg-green-500 text-white';
            case 'contacted':
                return 'bg-blue-500 text-white';
            case 'qualified':
                return 'bg-teal-500 text-white';
            case 'unqualified':
                return 'bg-red-500 text-white';
            default:
                return 'bg-gray-500 text-white';
        }
    }

    public function render()
    {
        $statuses = ['Yet to call', 'New', 'Contacted', 'Qualified', 'Unqualified'];

        $query = Lead::query();

        if ($this->searchLeads) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchLeads . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchLeads . '%')
                    ->orWhere('company', 'like', '%' . $this->searchLeads . '%')
                    ->orWhere('email', 'like', '%' . $this->searchLeads . '%');
            });
        }

        if (!empty($this->selectedStatuses)) {
            $query->where('status', $this->selectedStatuses);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $leads */
        $leads = $query->paginate(10);
        $leadIds = $leads->pluck('id');

        /** @var \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator $leads */

        $this->selectAll = $leadIds->isNotEmpty() && count(array_intersect($leadIds->toArray(), $this->selectedLeads)) === $leadIds->count();

        return view('livewire.assign-leads', [
            'leads' => $leads,
            'statuses' => $statuses,
            'leadTypes' => Lead::pluck('status')->filter()->unique()->values()->toArray(),
            'users' => User::all(),
        ]);
    }
}
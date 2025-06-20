<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LeadsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $assignedUser = '';
    public $selectedLeads = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'status' => ['except' => '', 'as' => 'st'],
        'assignedUser' => ['except' => '', 'as' => 'au'],
    ];

    public function updatedSearch($value)
    {
        $this->resetPage();
    }

    public function updatedStatus($value)
    {
        logger('Status filter updated:', ['status' => $value]);
        $this->resetPage();
    }

    public function updatedAssignedUser()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'assignedUser']);
        $this->resetPage();
    }

    public function viewLead($leadId)
    {
        return redirect()->route('leads.show', $leadId);
    }

    public function editLead($leadId)
    {
        return redirect()->route('leads.edit', $leadId);
    }

    public function deleteLead($leadId)
    {
        return redirect()->route('leads.delete', $leadId);
    }

    public function assignLeads()
    {
        // Dummy logic - replace with actual lead assignment
        if (!$this->selectedUser) {
            session()->flash('message', 'Please select a user to assign leads.');
            return;
        }

        // Example: Assign all filtered leads
        Lead::whereIn('id', $this->getFilteredLeadIds())
            ->update(['assigned_to' => $this->selectedUser]);

        session()->flash('message', 'Leads successfully assigned.');
    }

    protected function getFilteredLeadIds()
    {
        return Lead::query()
            ->when($this->searchLeads, fn($query) =>
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchLeads . '%')
                      ->orWhere('email', 'like', '%' . $this->searchLeads . '%');
                }))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->leadType, fn($q) => $q->where('type', $this->leadType))
            ->pluck('id');
    }
    
    public function render()
    {
        $leads = Lead::query()
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->status && $this->status !== '', function ($query) {
                logger('Applying status filter:', ['status' => $this->status]);
                $query->where('status', $this->status);
            })
            ->when($this->assignedUser, function ($query) {
                $query->whereHas('assignedUsers', function ($subQuery) {
                    $subQuery->where('user_id', $this->assignedUser);
                });
            })
            ->paginate(10);

        $users = User::all();

        return view('livewire.leads-table', [
            'leads' => $leads,
            'users' => $users,
        ]);
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

    public function assignSelectedLeads($leadIds)
    {
        // Placeholder for assigning selected leads
        session()->flash('message', 'Selected leads assigned successfully!');
        $this->selectedLeads = [];
        $this->selectAll = false;
    }

    public function deleteSelectedLeads($leadIds)
    {
        // Placeholder for deleting selected leads
        session()->flash('message', 'Selected leads deleted successfully!');
        $this->selectedLeads = [];
        $this->selectAll = false;
    }
}
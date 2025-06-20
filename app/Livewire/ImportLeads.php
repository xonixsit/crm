<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport;
use Illuminate\Support\Facades\Log;
use WireElements\Modal\Livewire\ModalComponent;

class ImportLeads extends ModalComponent
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required|mimes:csv,txt,xlsx|max:2048',
    ];

    public function import()
    {
        Log::info('Import method called.'); // ✅ LOG 1

        $this->validate();
        Log::info('Validation passed.'); // ✅ LOG 2

        try {
            Excel::import(new LeadsImport, $this->file);
            Log::info('Excel import completed.'); // ✅ LOG 3

            session()->flash('success', 'Leads imported successfully.');

            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Error importing leads: ' . $e->getMessage()); // ✅ LOG 4
            session()->flash('error', 'Import failed. Check logs.');
        }
    }

    public function render()
    {
        return view('livewire.import-leads');
    }
}

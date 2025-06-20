<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lead::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('primary_phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
        }

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('assigned_user') && $request->input('assigned_user') != '') {
            $query->whereHas('assignedUsers', function ($q) use ($request) {
                $q->where('user_id', $request->input('assigned_user'));
            });
        }
        
        $leads = $query->with('assignedUsers')->paginate(10);
        $users = User::all();
        $statuses = ['Yet To Call', 'Contacted', 'Qualified', 'Unqualified']; // Example statuses

        return view('leads.index', compact('leads', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('leads.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'primary_phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $users = User::all();
        return view('leads.edit', compact('lead', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'primary_phone' => 'nullable|string',
            'company' => 'nullable|string',
            'website' => 'nullable|string',
            'status' => 'nullable|string',
            'assigned_user_ids' => 'nullable|array',
            'assigned_user_ids.*' => 'exists:users,id'
        ]);

        $lead->update($request->all());

        // Sync assigned users (assuming many-to-many relation)
        $lead->assignedUsers()->sync($request->assigned_user_ids ?? []);
    
        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        Excel::import(new LeadsImport, $request->file('file'));

        return redirect()->route('leads.index')->with('success', 'Leads imported successfully.');
    }
}
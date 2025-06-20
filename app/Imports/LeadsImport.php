<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Lead([
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'primary_phone' => $row['primary_phone'] ?? null,
            'email' => $row['email'] ?? null,
            'company' => $row['company'] ?? null,
            'website' => $row['website'] ?? null,
            'status' => $row['status'] ?? 'Yet To Call',
            'assigned_user_id' => $row['assigned_user_id'] ?? 1, // Default to user with ID 1 if not provided
        ]);
    }
}
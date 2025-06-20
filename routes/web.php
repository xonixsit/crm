<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// web.php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Response;

Route::get('/', [HomeController::class, 'redirectToLogin']);

Route::get('/assign-leads', App\Livewire\AssignLeads::class);

Route::get('/sample-leads.csv', function () {
    $csvContent = <<<CSV
first_name,last_name,email,primary_phone,company,status,assigned_user_id
John,Doe,john.doe@example.com,1234567890,Acme Inc,New,1
Jane,Smith,jane.smith@example.com,2345678901,Globex Corp,Contacted,2
Alice,Johnson,alice.j@example.com,3456789012,Initech,Qualified,1
Bob,Brown,bob.brown@example.com,4567890123,Hooli,Lost,3
Charlie,White,charlie.white@example.com,5678901234,Stark Industries,New,2
CSV;

    return Response::make($csvContent, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="sample-leads.csv"',
    ]);
});

Route::get('/dashboard', function () {
    return \Inertia\Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Inertia routes
    Route::inertia('/leads', 'Leads/Index')->name('leads.index');
    Route::inertia('/assign-leads', 'Leads/Assign')->name('leads.assign');
});

Route::middleware('auth')->group(function () {
    Route::resource('leads', \App\Http\Controllers\LeadController::class);
    Route::post('leads/import', [\App\Http\Controllers\LeadController::class, 'import'])->name('leads.import');
    Route::get('/users', \App\Livewire\UsersTable::class)->name('users.index');
    Route::get('/users/{user}', App\Livewire\ShowUser::class)->name('users.show');
    Route::get('/users/{user}/edit', App\Livewire\EditUser::class)->name('users.edit');
    Route::get('/users/{user}/delete', App\Livewire\DeleteUser::class)->name('users.delete');
});

require __DIR__ . '/auth.php';
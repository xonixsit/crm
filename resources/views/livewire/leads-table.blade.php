<div x-data="{ selectedLeads: @entangle('selectedLeads') }">
    @if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif

    <!-- Filters -->
    <div wire:ignore.self class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" wire:model.live="search" placeholder="Search by name or email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white placeholder:text-gray-500">

            <select wire:model.live="status" class="w-full md:w-52 px-4 py-3 rounded-xl bg-gray-700 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">All Statuses</option>
                @foreach(['Yet to call', 'New', 'Contacted', 'Qualified', 'Unqualified'] as $statusOption)
                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                @endforeach
            </select>

            <!-- <div class="text-white mt-2">Selected: {{ $status }}</div> -->
            
            <select wire:model="assignedUser"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                <option value="">All Users</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <div class="flex space-x-2">
                <button wire:click="resetFilters"
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-semibold rounded-md shadow">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Toolbar -->
    <div class="mb-4" x-data="{ selectedLeads: @entangle('selectedLeads').defer, open: false }">
        <div class="flex items-center space-x-3">
            <input type="checkbox" wire:model.live="selectAll"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-indigo-600">
            <label for="select-all" class="text-sm font-medium text-gray-700 dark:text-gray-300">Select All</label>

            <div x-show="selectedLeads.length > 0" class="relative inline-block text-left">
                <button type="button" @click="open = !open"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                    Bulk Actions
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700 z-50">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <button type="button" wire:click="assignSelectedLeads"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" role="menuitem">
                            Assign Selected
                        </button>
                        <button type="button" wire:click="deleteSelectedLeads"
                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900 dark:text-red-200 dark:hover:bg-red-700 dark:hover:text-white" role="menuitem">
                            Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white/10 dark:bg-gray-900/10 backdrop-blur-md shadow-lg rounded-xl border border-white/10 dark:border-gray-700">
        <table class="min-w-full text-sm text-left text-gray-200 dark:text-gray-100">
            <thead class="text-xs uppercase bg-white/20 dark:bg-gray-800/20 text-gray-300 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-check-square class="w-4 h-4 text-indigo-400" />
                        </div>
                    </th>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-user class="w-4 h-4 text-indigo-400" />
                            First Name
                        </div>
                    </th>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-user class="w-4 h-4 text-indigo-400" />
                            Last Name
                        </div>
                    </th>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-mail class="w-4 h-4 text-blue-400" />
                            Email
                        </div>
                    </th>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-phone class="w-4 h-4 text-green-400" />
                            Phone
                        </div>
                    </th>
                    <th class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-lucide-check-circle class="w-4 h-4 text-white/60" />
                            Status
                        </div>
                    </th>
                    <th class="px-6 py-4 text-right">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse ($leads as $lead)
                <tr class="hover:bg-white/10 transition-all">
                    <td class="px-6 py-4"><input type="checkbox" wire:model.live="selectedLeads" value="{{ $lead->id }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-indigo-600">
                    </td>
                    <td class="px-6 py-4 font-medium text-white">{{ $lead->first_name }}</td>
                    <td class="px-6 py-4 font-medium text-white">{{ $lead->last_name }}</td>
                    <td class="px-6 py-4">{{ $lead->email }}</td>
                    <td class="px-6 py-4">{{ $lead->primary_phone }}</td>
                    @php
                    $statuses = [
                    'Yet to call' => [
                    'label' => 'Yet To Call',
                    'icon' => 'phone-missed',
                    'bg' => 'bg-yellow-500'
                    ],
                    'New' => [
                    'label' => 'New',
                    'icon' => 'sparkles',
                    'bg' => 'bg-indigo-500',
                    'text' => 'text-white'
                    ],
                    'Contacted' => [
                    'label' => 'Contacted',
                    'icon' => 'phone',
                    'bg' => 'bg-blue-500',
                    'text' => 'text-white'
                    ],
                    'Qualified' => [
                    'label' => 'Qualified',
                    'icon' => 'check',
                    'bg' => 'bg-green-500',
                    'text' => 'text-white'
                    ],
                    'Lost' => [
                    'label' => 'Lost',
                    'icon' => 'x-circle',
                    'bg' => 'bg-red-500',
                    'text' => 'text-white'
                    ],
                    ];


                    $s = $statuses[$lead->status] ?? ['label' => $lead->status, 'icon' => 'help-circle', 'bg' => 'bg-amber-500', 'text' => 'text-white-800'];
                    @endphp

                    <td class="px-6 py-4">
                        <div class="inline-flex w-full items-center justify-center gap-2 whitespace-nowrap w-32 h-8 rounded-full {{ $s['bg'] }} {{ $s['text'] }}">
                            <!-- <x-lucide-{{$s['icon']}} class="w-4 h-4" /> -->
                            <span>{{ $s['label'] }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('leads.show', $lead->id) }}" class="text-indigo-400 hover:text-indigo-300 flex items-center space-x-1">
                                <x-lucide-eye class="w-4 h-4" />
                                <span>View</span>
                            </a>

                            <a href="{{ route('leads.edit', $lead->id) }}" class="text-yellow-400 hover:text-yellow-300 flex items-center">
                                <x-lucide-pencil-line class="w-4 h-4" />
                            </a>

                            <form wire:submit.prevent="deleteLead({{ $lead->id }})" onsubmit="return confirm('Are you sure you want to delete this lead?')">
                                <button type="submit" class="text-red-400 hover:text-red-300 flex items-center">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-400">No leads found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $leads->links() }}
        </div>
    </div>

    @script
    <script>
        $wire.on('refreshPage', () => {
            window.location.reload();
        });
    </script>
    @endscript
</div>
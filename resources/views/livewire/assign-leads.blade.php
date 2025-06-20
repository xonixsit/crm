<div class="p-6 bg-gray-900 text-white min-h-screen font-inter w-full">
    <div class="max-w-screen-xl mx-auto space-y-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <x-lucide-users class="w-8 h-8 text-blue-400" />
                Assign Leads to User
            </h1>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3">
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <x-lucide-plus class="w-5 h-5" /> Add Lead
                </button>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <x-lucide-upload class="w-5 h-5" /> Import Leads
                </button>
            </div>
        </div>

        @php
        $statuses = ['Yet to call', 'New', 'Contacted', 'Qualified', 'Unqualified'];
        @endphp

        <!-- Filters + Assign -->
        <div class="bg-gray-800 p-4 rounded-xl shadow-lg space-y-4 md:space-y-0 md:flex md:items-center md:justify-between mb-6">

            <!-- Left: Lead Filters -->
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-2/3 md:items-center">
                <!-- Lead Search -->
                <input
                    type="text"
                    placeholder="Search by name or email..."
                    wire:model.live.debounce.300ms="searchLeads"
                    class="w-full md:w-64 p-3 rounded-xl bg-gray-700 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500" />

                <!-- Status Filter -->
                <div class="flex items-center space-x-4">
                    <select wire:model.live="selectedStatuses" class="w-full md:w-52 px-4 py-3 rounded-xl bg-gray-700 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                        <option value="">All Statuses</option>
                        @foreach(['Yet to call', 'New', 'Contacted', 'Qualified', 'Unqualified'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Right: User Assignment + Assign Button -->
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto md:items-center justify-end mt-4 md:mt-0">
                <!-- User Assignment -->
                <div x-data="{ query: '', open: false, showAll: false }" class="relative w-full md:w-64">
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Search and select user..."
                            x-model="query"
                            @focus="open = true; showAll = true"
                            @keydown.escape.window="open = false"
                            @click.outside="open = false"
                            class="w-full pr-10 p-3 bg-[#151A28] text-white border border-[#2A2F45] rounded-lg focus:ring-2 focus:ring-green-500" />

                        <!-- Chevron -->
                        <div
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white cursor-pointer"
                            @click.stop="open = !open; showAll = true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <ul
                        x-show="open"
                        x-transition
                        class="absolute w-full mt-2 bg-[#1A1F30] border border-[#2A2F45] rounded-xl shadow-xl max-h-60 overflow-y-auto z-50 space-y-1 py-2 custom-scrollbar">
                        @foreach ($users as $user)
                        <li
                            @click.prevent="
                        window.Livewire.find('{{ $this->getId() }}')
                            .set('selectedUser', {{ $user->id }});
                        query = '{{ addslashes($user->name) }} ({{ addslashes($user->email) }})';
                        open = false;
                        showAll = false;
                    "
                            x-show="showAll || '{{ strtolower($user->name . ' ' . $user->email) }}'.includes(query.toLowerCase())"
                            class="px-4 py-2 text-white hover:bg-green-600 cursor-pointer transition duration-150">
                            {{ $user->name }} <span class="text-sm text-gray-400">({{ $user->email }})</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Assign Button -->
                <button
                    wire:click="assignLeads"
                    class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 whitespace-nowrap">
                    🚀 Assign
                </button>
            </div>
        </div>


        <!-- Success Message -->
        @if (session()->has('message'))
        <div class="mb-6 p-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('message') }}
        </div>
        @endif

        <!-- Leads Table -->
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-700 text-white">
                    <tr class="border-b border-gray-600">
                        <th class="py-2 px-4">
                            <input type="checkbox" wire:model="selectAll" class="form-checkbox w-5 h-5 text-blue-500">
                        </th>
                        <th class="py-2 px-4">First Name</th>
                        <th class="py-2 px-4">Last Name</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Phone</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr class="border-b border-gray-600 hover:bg-gray-700" wire:key="{{ $lead->id }}">
                        <td class="py-2 px-4">
                            <input type="checkbox" wire:model="selectedLeads" value="{{ $lead->id }}" class="form-checkbox w-5 h-5 text-blue-500">
                        </td>
                        <td class="py-2 px-4">{{ $lead->first_name }}</td>
                        <td class="py-2 px-4">{{ $lead->last_name }}</td>
                        <td class="py-2 px-4">
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $lead->email }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-gray-600 hover:text-red-500"
                                    title="Send Email">
                                    <x-lucide-mail class="w-4 h-4" />
                                </a>
                                {{ Str::mask($lead->email, '*', 0, 5) }}
                            </div>
                        </td>

                        <td class="py-2 px-4 items-center gap-2">
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <x-lucide-phone class="w-4 h-4 text-gray-500" />
                                {{ Str::mask($lead->primary_phone, '*', -6, 6) }}
                            </div>
                        </td>
                        <td class="py-2 px-4">
                            <span class="px-3 py-1 rounded-lg text-sm font-medium {{ $this->getStatusClass($lead->status) }}">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                        <td class="py-2 px-4 flex gap-2">
                            <a href="#" class="text-yellow-400 hover:text-yellow-500">
                                <x-lucide-eye class="w-5 h-5" />
                            </a>
                            <a href="#" class="text-green-400 hover:text-green-500">
                                <x-lucide-pencil class="w-5 h-5" />
                            </a>
                            <a href="#" class="text-red-400 hover:text-red-500">
                                <x-lucide-trash-2 class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b border-gray-600">
                        <td colspan="7" class="py-2 px-4 text-center text-gray-400">No leads match your search.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
            </div>

        </div>


    </div>
</div>
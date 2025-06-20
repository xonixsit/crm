<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Card -->
        <div class="bg-white/20 dark:bg-gray-800/30 backdrop-blur-xl border border-white/10 dark:border-gray-700 shadow-2xl rounded-3xl p-8 ring-1 ring-white/10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-lucide-list class="w-6 h-6 text-indigo-500" />
                        Lead List
                    </h3>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                    <!-- Add Lead Button -->
                    <a href="{{ route('leads.create') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <x-lucide-plus-circle class="w-4 h-4" />
                        Add Lead
                    </a>

                    <!-- Import Leads Button -->
                    <button type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        wire:click="$dispatch('openModal', { component: 'import-leads' })">
                        <x-lucide-upload-cloud class="w-4 h-4" />
                        Import Leads
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Livewire Leads Table -->
            <livewire:leads-table wire:navigate />
        </div>
    </div>
</x-app-layout>

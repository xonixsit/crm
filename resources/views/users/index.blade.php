<x-app-layout>
   
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Glassmorphic Card -->
            <div class="bg-white/20 dark:bg-gray-800/30 backdrop-blur-lg border border-white/30 dark:border-gray-700 rounded-2xl shadow-xl p-6 transition duration-300 ease-in-out hover:shadow-2xl">

                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <div>
                        <h3 class="text-xl md:text-2xl font-semibold text-gray-900 dark:text-white">User List</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Managing a network worth ₹250 Lakh Crore+</p>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('success'))
                    <div class="bg-green-200/30 border border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg mb-5 shadow-inner backdrop-blur-sm">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Livewire Users Table -->
                <livewire:users-table wire:navigate />

            </div>
        </div>
    </div>
</x-app-layout>

<div>
    @if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif

    <div class="bg-[#1A1F2B] text-white rounded-2xl p-6 shadow-lg border border-white/10 backdrop-blur-md">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h3 class="text-2xl font-semibold flex items-center gap-2">
                <x-lucide-users class="w-6 h-6 text-violet-400" />
                User List
            </h3>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <!-- Search Input -->
                <div class="relative flex-1 sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-lucide-search class="w-4 h-4 text-gray-400" />
                    </div>
                    <input
                        type="text"
                        placeholder="Search users..."
                        class="w-full bg-[#2A2F3C] border border-white/10 text-white rounded-lg pl-10 pr-4 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500" />
                </div>

                <!-- Add User Button -->
                <button
                    class="flex items-center justify-center gap-2 bg-violet-600 hover:bg-violet-500 transition px-4 py-2 rounded-lg text-white font-medium whitespace-nowrap">
                    <x-lucide-plus class="w-4 h-4" />
                    Add User
                </button>
            </div>
        </div>


        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#2A2F3C] text-gray-400 uppercase tracking-wider">
                    <tr class="text-left text-sm text-gray-300 bg-gray-800/40">
                        <th class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-lucide-check-square class="w-4 h-4 text-indigo-400" />
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium tracking-wide uppercase text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-lucide-user class="w-4 h-4 text-indigo-400" />
                                <span>Name</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium tracking-wide uppercase text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-lucide-mail class="w-4 h-4 text-indigo-400" />
                                <span>Email</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium tracking-wide uppercase text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-lucide-folder-open class="w-4 h-4 text-indigo-400" />
                                <span>Leads</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium tracking-wide uppercase text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-lucide-share-2 class="w-4 h-4 text-indigo-400" />

                                Assign
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium tracking-wide uppercase text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-lucide-more-horizontal class="w-4 h-4 text-indigo-400" />
                                <span>Actions</span>
                            </div>
                        </th>

                    </tr>



                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-[#262C3C] transition">
                        <td class="px-6 py-4"><input type="checkbox" wire:model.live="selectedUsers" value="{{ $user->id }}"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-indigo-600">
                        </td>
                        <!-- Name -->
                        <td class="px-4 py-3 font-medium text-white">
                            {{ $user->name }}
                        </td>

                        <!-- Email -->
                        <td class="px-4 py-3 text-white/80">
                         {{  $user->email }}
                        </td>

                        <!-- Leads Count -->
                        <td class="px-4 py-3">
                            <span class="inline-block px-3 py-1 bg-violet-600/20 text-violet-300 text-xs rounded-full">
                                {{ $user->leads_count ?? 0 }} Leads
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <button type="button" wire:click="assignLeads($user->id)"
                                class="mt-2 bg-violet-600 hover:bg-violet-500 text-white font-semibold px-4 py-2 rounded">
                                Assign Leads
                            </button>
                        </td>
                        <!-- Actions -->
                        <td class="px-4 py-6 flex justify-center space-x-3">
                            <div wire:click="viewUser({{ $user->id }})" class="cursor-pointer text-blue-500 hover:text-blue-400"><x-lucide-eye class="w-4 h-4" /></div>
                            <div wire:click="editUser({{ $user->id }})" class="cursor-pointer text-yellow-500 hover:text-yellow-400"><x-lucide-pencil class="w-4 h-4" /></div>
                            <div wire:click="deleteUser({{ $user->id }})" class="cursor-pointer text-red-500 hover:text-red-400"><x-lucide-trash class="w-4 h-4" /></div>
                        </td>
                        <!-- Assign -->

                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links()}}
        </div>
    </div>


</div>
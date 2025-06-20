<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 px-6">
        <div class="bg-gradient-to-br from-[#1F2937] to-[#111827] rounded-2xl border border-white/10 shadow-xl p-8 text-white">
            <!-- Title -->
            <div class="flex items-center gap-3 mb-6">
                <x-lucide-info class="w-6 h-6 text-indigo-400" />
                <h2 class="text-2xl font-bold">Lead Details</h2>
            </div>

            <!-- Header summary -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold">{{ $lead->first_name }} {{ $lead->last_name }}</h3>
                <p class="text-sm text-gray-400">Lead info and assignment summary</p>
            </div>

            <!-- Info rows -->
            <div class="divide-y divide-white/10 space-y-4">

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-badge-info class="w-5 h-5 text-red-400" />
                        <span class="text-white/80">Full Name</span>
                    </div>
                    <span class="text-white/90">{{ $lead->first_name }} {{ $lead->last_name }}</span>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-mail class="w-5 h-5 text-pink-400" />
                        <span class="text-white/80">Email Address</span>
                    </div>
                    <span class="text-white/90">{{ $lead->email }}</span>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-phone class="w-5 h-5 text-green-400" />
                        <span class="text-white/80">Phone</span>
                    </div>
                    <span class="text-white/90">{{ $lead->primary_phone }}</span>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-building class="w-5 h-5 text-blue-400" />
                        <span class="text-white/80">Company</span>
                    </div>
                    <span class="text-white/90">{{ $lead->company }}</span>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-globe class="w-5 h-5 text-yellow-400" />
                        <span class="text-white/80">Website</span>
                    </div>
                    <a href="{{ $lead->website }}" target="_blank" class="text-blue-400 hover:underline">
                        {{ $lead->website }}
                    </a>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-badge-check class="w-5 h-5 text-purple-400" />
                        <span class="text-white/80">Status</span>
                    </div>
                    @php
                        $statusStyles = [
                            'Yet to call' => 'bg-gray-600',
                            'New' => 'bg-indigo-600',
                            'Contacted' => 'bg-blue-500',
                            'Qualified' => 'bg-green-500',
                            'Lost' => 'bg-red-500',
                        ];
                        $statusColor = $statusStyles[$lead->status] ?? 'bg-gray-600';
                    @endphp
                    <span class="px-3 py-1 text-sm rounded-full font-medium {{ $statusColor }} text-white">
                        {{ $lead->status }}
                    </span>
                </div>

                <!-- Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <x-lucide-layers class="w-5 h-5 text-indigo-400" />
                        <span class="text-white/80">Assigned Users</span>
                    </div>
                    <div class="flex gap-2">
                        @forelse($lead->assignedUsers as $user)
                            <span class="text-sm font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-3 py-1 rounded-full">
                                {{ $user->name }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-400">None</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-white/10">
                <a href="{{ route('leads.edit', $lead->id) }}"
                   class="hover:bg-indigo-500 bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2">
                    <x-lucide-pencil class="w-4 h-4" /> Edit
                </a>

                <form method="POST" action="{{ route('leads.destroy', $lead->id) }}"
                      onsubmit="return confirm('Are you sure you want to delete this lead?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="hover:bg-red-500 bg-red-600 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-lucide-trash-2 class="w-4 h-4" /> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

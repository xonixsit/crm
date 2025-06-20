<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="backdrop-blur-lg bg-white/5 border border-white/10 shadow-2xl rounded-3xl overflow-hidden">
        <div class="flex items-center space-x-4 px-6 py-6 border-b border-white/10">
            <x-lucide-user class="h-8 w-8 text-indigo-400" />
            <h2 class="text-3xl font-bold text-white tracking-tight">User Details</h2>
        </div>

        <div class="px-6 py-6 border-b border-white/10 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold text-white">{{ $user->name }}</h3>
                <p class="text-sm text-gray-400">Personal info and summary of assigned leads</p>
            </div>
            
        </div>

        <div class="divide-y divide-white/10">
            <div class="flex items-center px-6 py-5 gap-4 hover:bg-white/5 transition">
                <x-lucide-badge-info class="h-5 w-5 text-red-400" />
                <div class="w-1/3 text-sm font-medium text-gray-300">Full Name</div>
                <div class="text-sm text-white">{{ $user->name }}</div>
            </div>

            <div class="flex items-center px-6 py-5 gap-4 hover:bg-white/5 transition">
                <x-lucide-mail class="h-5 w-5 text-pink-400" />
                <div class="w-1/3 text-sm font-medium text-gray-300">Email Address</div>
                <div class="text-sm text-white">{{ $user->email }}</div>
            </div>

            <div class="flex items-center px-6 py-5 gap-4 hover:bg-white/5 transition">
                <x-lucide-list-check class="h-6 w-6 text-gray-400" />
                <div class="w-1/3 text-sm font-medium text-gray-300">Assigned Leads</div>
                <div class="flex-1 flex items-center justify-between text-sm text-white">
                    <span class="inline-block bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $user->leads_count }}
                    </span>
                    <div class="flex space-x-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="hover:text-yellow-400 transition">
                            <x-lucide-pencil-line class="w-5 h-5" />
                        </a>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-500 transition">
                                <x-lucide-trash class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

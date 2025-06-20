<!-- In your layout blade -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<x-app-layout>


    <div class="py-10 px-6 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-[#1F2937] to-[#111827] p-8 rounded-2xl shadow-xl border border-white/10">

                <!-- Title with icon -->
                <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
                    <x-lucide-info class="w-5 h-5 text-indigo-400" />
                    <h3 class="text-xl font-semibold text-white">Lead Details</h3>
                </div>

                <form method="POST" action="{{ route('leads.update', $lead->id) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-user class="w-4 h-4 text-pink-400" /> First Name
                            </label>
                            <input id="first_name" name="first_name" type="text"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('first_name', $lead->first_name) }}" required />
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-user class="w-4 h-4 text-pink-400" /> Last Name
                            </label>
                            <input id="last_name" name="last_name" type="text"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('last_name', $lead->last_name) }}" required />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Primary Phone -->
                        <div>
                            <label for="primary_phone" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-phone class="w-4 h-4 text-green-400" /> Primary Phone
                            </label>
                            <input id="primary_phone" name="primary_phone" type="text"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('primary_phone', $lead->primary_phone) }}" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-mail class="w-4 h-4 text-pink-400" /> Email
                            </label>
                            <input id="email" name="email" type="email"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('email', $lead->email) }}" />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Company -->
                        <div>
                            <label for="company" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-building class="w-4 h-4 text-blue-400" /> Company
                            </label>
                            <input id="company" name="company" type="text"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('company', $lead->company) }}" />
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-globe class="w-4 h-4 text-yellow-400" /> Website
                            </label>
                            <input id="website" name="website" type="text"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                value="{{ old('website', $lead->website) }}" />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label for="status" class="flex items-center gap-2 text-sm text-white/80 mb-1">
                                <x-lucide-badge-check class="w-4 h-4 text-purple-400" /> Status
                            </label>
                            <select id="status" name="status"
                                class="w-full rounded-lg px-4 py-2 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option disabled>Select Status</option>
                                <option value="Yet To Call" {{ old('status', $lead->status) == 'Yet To Call' ? 'selected' : '' }}>Yet To Call</option>
                                <option value="Contacted" {{ old('status', $lead->status) == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="Qualified" {{ old('status', $lead->status) == 'Qualified' ? 'selected' : '' }}>Qualified</option>
                                <option value="Unqualified" {{ old('status', $lead->status) == 'Unqualified' ? 'selected' : '' }}>Unqualified</option>
                            </select>
                        </div>

                        <!-- Assigned Users -->
                        <!-- Assigned Users -->
                        <!-- Assigned Users -->
                        <!-- Assigned Users -->
                        <div>
                            <label for="assigned_user_ids" class="flex items-center gap-2 text-sm text-indigo-400 mb-1">
                                <x-lucide-users class="w-4 h-4" /> Assigned Users
                            </label>

                            <select id="assigned_user_ids" name="assigned_user_ids[]" multiple class="tom-select w-full">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, old('assigned_user_ids', $lead->assignedUsers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 text-right">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2">
                            <x-lucide-save class="w-4 h-4" /> Update Lead
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
@push('scripts')
<script>
    new TomSelect("#assigned_user_ids", {
        plugins: ['remove_button'],
        render: {
            item: function(data, escape) {
                return `<div class="bg-indigo-600 text-white text-sm font-medium rounded-full px-3 py-1 mr-2 mb-1 flex items-center gap-2 shadow">
                            <span>${escape(data.text)}</span>
                            <button class="hover:text-red-300 text-white" data-value="${escape(data.value)}">&times;</button>
                        </div>`;
            },
            option: function(data, escape) {
                return `<div class="hover:bg-indigo-600 hover:text-white px-4 py-2 cursor-pointer rounded">${escape(data.text)}</div>`;
            }
        },
        dropdownClass: 'bg-gray-900 border border-gray-700 rounded-lg mt-1 shadow-lg p-2',
        controlInput: '<input class="bg-transparent text-white px-2 py-1 outline-none w-full" type="text" autocomplete="off" />',
    });
</script>
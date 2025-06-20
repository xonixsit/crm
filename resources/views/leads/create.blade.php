<x-app-layout>
    <!--  -->

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 space-y-6 transition-all">

                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-100 flex items-center gap-2">
                    <x-lucide-user-plus class="w-5 h-5 text-indigo-500" />
                    New Lead Details
                </h3>

                <form method="POST" action="{{ route('leads.store') }}" class="space-y-6">
                    @csrf

                    {{-- Name Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text"
                                class="mt-1 w-full" :value="old('first_name')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text"
                                class="mt-1 w-full" :value="old('last_name')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="primary_phone" :value="__('Primary Phone')" />
                            <x-text-input id="primary_phone" name="primary_phone" type="text"
                                class="mt-1 w-full" :value="old('primary_phone')" />
                            <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email"
                                class="mt-1 w-full" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Company Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="company" :value="__('Company')" />
                            <x-text-input id="company" name="company" type="text"
                                class="mt-1 w-full" :value="old('company')" />
                            <x-input-error :messages="$errors->get('company')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="text"
                                class="mt-1 w-full" :value="old('website')" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Status & Assignment --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status"
                                class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="Yet To Call" {{ old('status') == 'Yet To Call' ? 'selected' : '' }}>Yet To Call</option>
                                <option value="Contacted" {{ old('status') == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="Qualified" {{ old('status') == 'Qualified' ? 'selected' : '' }}>Qualified</option>
                                <option value="Unqualified" {{ old('status') == 'Unqualified' ? 'selected' : '' }}>Unqualified</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="assigned_user_id" :value="__('Assigned To')" />
                            <select id="assigned_user_id" name="assigned_user_id"
                                class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_user_id')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                        <x-primary-button class="px-6 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow">
                            <x-lucide-save class="w-4 h-4 mr-2" />
                            {{ __('Create Lead') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

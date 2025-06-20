<div>
    <h2 class="text-2xl font-bold mb-4">Delete User</h2>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <p class="text-gray-700 dark:text-gray-300 text-lg mb-4">
            Are you sure you want to delete user: <strong>{{ $user->name }} ({{ $user->email }})</strong>?
        </p>
        <p class="text-red-500 text-sm mb-6">
            This action cannot be undone.
        </p>

        <div class="flex items-center justify-between">
            <button wire:click="deleteUser" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Delete User
            </button>
            <a href="{{ route('users.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancel
            </a>
        </div>
    </div>
</div>

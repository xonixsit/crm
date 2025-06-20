<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Import Leads</h2>

    <form wire:submit.prevent="import">
        <input type="file" wire:model="file" class="mb-4">
        @error('file') <span class="text-red-500">{{ $message }}</span> @enderror

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
                Upload
            </button>
        </div>
    </form>
</div>

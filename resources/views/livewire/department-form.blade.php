<div>
    <input type="text" wire:model="name" class="rounded-md bg-transparent text-white" />
    <button class="rounded-md px-4 py-2 border text-white hover:text-gray-400 hover:border-gray-400" wire:click="submit">Submit</button>
    @if($success) <div>Saved</div> @endif
</div>

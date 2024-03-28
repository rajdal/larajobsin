
<div>
    <x-header></x-header>
    <div class="pt-20 px-52 py-52">
        <form wire:submit="create">
            {{ $this->form }}

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Submit
            </button>
        </form>

        <x-filament-actions::modals />
    </div>
</div>


{{-- @extends('layouts.app')
@section('content') --}}
<div>
    <section class="relative min-w-ful">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="{{route('home')}}" wire:navigate class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                LarajobsIndia
            </a>
            <div class="w-full dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">

                <form wire:submit="userLogin">
                    @csrf
                    {{ $this->form }}

                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Login
                    </button>
                </form>
            </div>

            {{-- <x-filament-actions::modals /> --}}
        </div>
    </section>
    @livewire('notifications')
</div>
{{-- @endsection --}}


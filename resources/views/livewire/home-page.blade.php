
{{-- <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head> --}}
    <div>
    {{-- </x-filament::modal>
    <x-filament-actions::modals/> --}}
    @livewire('notifications')
        <x-header></x-header>
        <x-sub-heading></x-sub-heading>
        <x-brand-carousel></x-brand-carousel>
        {{-- <x-type-filter></x-type-filter> --}}
        <div class="flex flex-row items-center justify-center w-full mt-10">
            <button type="button" wire:click='filter("all")' class="items-center px-2 py-2 mr-2 text-blue-600 shadow-lg bg-md-white rounded-2xl font-large text-medium text hr-10 mw-full ring-1 ring-inset ring-blue-300-">All Jobs</button>
            @foreach ($tags as $tag )
            <button type="button" wire:click='filter("{{$tag->name}}")' class="items-center px-2 py-2 mr-2 text-blue-600 bg-white shadow-lg rounded-2xl font-large text-medium text hr-10 mw-full ring-1 ring-inset ring-blue-300">{{$tag->name}}</button>

            @endforeach
            </div>
        <div wire:model="jobs" class="mb-20">
            @foreach ($jobs as $job)
                <x-job-card :job="$job"></x-job-card>
            @endforeach
        </div>
        <x-footer></x-footer>

    </div>
    <script>
        window.addEventListener('livewire:load', function () {
            const swiper = new Swiper('.carousel',{
                spaceBetween: 5,
                centeredSlides: true,
                autoplay: {
                    delay: 1000,
                },
            });
        })
    </script>


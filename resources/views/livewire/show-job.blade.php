<div>
    <x-header></x-header>
    <div class="mx-auto px-52 py-52 lg:py-2">
        <x-job-detail-card :job="$job" :company="$company"></x-company-detail-card>
    </div>
    <x-footer></x-footer>
    @livewire('notifications')
</div>

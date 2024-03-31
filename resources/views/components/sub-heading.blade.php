<div class="mt-2 mb-2 text-center">

        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'employer']))
        <button
        class="relative rotate-3 shadow-lg inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <a href="{{ route('post.job') }}" wire:navigate
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0" >
                Post Job
            </a>
        </button>
        <button
        class="relative -rotate-3 shadow-lg mb-10 inline-flex items-center justify-center p-0.5 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <a href="{{ route('login') }}" wire:navigate
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Hire Freelancer
            </a>
        </button>
        @endif

        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'candidate']))
        <button
        class="relative rotate-3 shadow-lg inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <a href="{{ route('create.resume') }}" wire:navigate
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0" >
                Resume
            </a>
        </button>
        @endif



    <h1 class="text-4xl font-extrabold tracking-tight text-black sm:text-5xl md:text-6xl">
        <span class="block text-5xl font-Roboto xl:inline">Laravel Talent Hub: Where Opportunities Flourish</span>
    </h1>
    <p class="max-w-md mx-auto mt-3 text-base text-black sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
    </p>
    <div class="max-w-2xl mx-auto font-medium">
        “LaraJobs is our first stop whenever we're hiring a Laravel role. We've hired 10 Laravel developers in the last
        few years, all thanks to LaraJobs.”
        — <span class="text-base">Matthew Hall, ArborXR</span>
    </div>
</div>

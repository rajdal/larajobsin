{{dd($records)}}
<a href="{{$record->apply_url}}" target="_blank">
    <div class="flex flex-row items-center justify-center w-full mt-10" wire:key="$job->id">
            <div class="relative flex items-center px-2 py-5 rounded-lg shadow-lg md:px-6 md:space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
            style="min-height:110px;background-color: {{$record->hilight_color ?? '#fcffde'}}; min-width: 50%">

            <div
                class="flex-shrink-0 hidden mb-2 border border-[{{$record->hilight_color}}]  shadow-xl rounded-lg sm:block md:mb-0 lg:absolute md:p-4 md:bg-white md:-left-9">
                <img src="{{ $record->company->getFirstMediaUrl('company-logo') ?? 'https://larajobs.com/logos/46bxEYQ5qExDksLAkW6KbOoQnUm3eODo0SbiSTHP.png' }}" alt="logo""
                    class="object-contain w-24 h-24 rounded-lg">
            </div>
            <div class="flex flex-col w-full md:flex-row">
                <div class="flex-1 w-full min-w-0 px-2 mx-10 mb-2 md:pl-6 md:mb-0" style="color:#2d3748;">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm text-gray-500 truncate" style="color:#2d3748;">{{$record->company->name}}</p>
                    <p class="text-lg font-bold text-gray-900" style="color:#2d3748;">{{$record->title}}</p>
                    <p class="text-sm text-gray-500 truncate" style="color:#2d3748;">
                        {{Str::replace('_', ' ',(Str::title($record->employment_type)))." - ". $record->salary_from. " - ". $record->salary_to}}
                    </p>
                </div>
                <div class="flex-col flex-none px-2 text-sm text-gray-500 md:flex md:justify-end" style="color:#2d3748;">
                    <div class="flex-none mb-4 md:flex sm:justify-end">
                        <div class="flex items-center mb-1 mr-4 text-sm text-gray-500 truncate md:mb-0"
                            style="color:#2d3748;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{$record->location}}
                        </div>
                        <div class="flex items-center" style="color:#2d3748;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{$record->created_at->diffForHumans()}}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1 mt-2 md:gap-2 md:justify-end">
                        @foreach (explode(',', $record->tags) as $tag)
                        <div
                            class="self-center px-2 py-1 text-sm font-bold whitespace-no-wrap rounded-full tag text-accent">
                            {{$tag}}
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        {{-- </a> --}}
    </div>
</a>

{{-- <a href="#" class="flex flex-row items-center justify-center w-full mt-10">
    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
    <div class="flex flex-col justify-between p-4 leading-normal">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
    </div>
</a> --}}

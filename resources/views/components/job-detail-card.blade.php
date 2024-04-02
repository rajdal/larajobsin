<div class="flex flex-col justify-center w-full mt-2 items-left">
    <div class="mb-4 text-2xl font-bold text-gray-900">
        {{$job->title}}
    </div>
    <div class="p-4 mb-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Company
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {{$company->name}}
         </div>
    </div>
    <div class="p-4 mb-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Tags
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             @foreach(explode(',', $job->tags) as $tag)
                {{$tag}}
             @endforeach
         </div>
    </div>
    <div class="p-4 mb-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Salary Range
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {{$job->salary_from}} - {{$job->salary_to}}
         </div>
    </div>
    <div class="p-4 mb-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Location
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {{$job->location}}
         </div>
    </div>
    <div class="p-4 mb-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Type
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {{Str::title(Str::replace('_',' ',$job->employment_type))}}
         </div>
    </div>
    <div class="p-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Job Description
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {!!$job->job_description!!}
         </div>
    </div>
    <div class="p-4 mt-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Job Requirements
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {!!$job->job_requirement!!}
         </div>
    </div>
    <div class="p-4 mt-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Job Benifits
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {!!$job->job_benefits!!}
         </div>
    </div>
    <div class="p-4 mt-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Qualification
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {!!$job->qualification!!}
         </div>
    </div>
    <div class="p-4 mt-4 border rounded-md shadow-md bg-gray-50">
        <div class="mt-2 mb-2 font-bold text-left">
            Experience
        </div>
        <div class="font-normal text-left text-gray-900 text-medium">
             {!!$job->experience!!}
         </div>
    </div>
    <button type="button" wire:click="apply('{{$job->id}}')" class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Apply</button>
</div>

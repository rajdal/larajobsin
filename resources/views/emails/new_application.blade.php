<x-mail::message>
# New Application

Hello,

Following candidate has been applied for a job. Please review the attached application.

<x-mail::panel>
Name: {{ $data['name'] }}

Email: {{ $data['email'] }}

Phone: {{ $data['phone'] }}

Linkedin : {{$data['linkedin_url'] ?? ""}}

Github : {{$data['github_url'] ?? ""}}

</x-mail::panel>

Please find the resume of applicant attached herewith.

{{-- <x-mail::button :url="$url">
View Order
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

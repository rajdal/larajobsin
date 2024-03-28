<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.6/filepond.css" integrity="sha512-+9N9eHaPFoACOB0WABsAByw8rE3wPrCdY9DSUS5vM7qjss4w9g8CcKHDULxhVL/bg3zNVad4TIRUEdSujIjxcw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.6/filepond.min.js" integrity="sha512-6ALP4noOAk3f/wpnN0qAWdkNNTpQcu0ArDsPVVFi3GIKbTGHswBnW3o/8rsxDTGF4BGYpI4E6DlrtyGFgBifjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @filamentStyles
    </head>
    <body class="flex flex-col min-h-screen font-sans antialiased">


        <div class="min-h-screen">
            <main>
                @yield('content')
            </main>
        </div>
        @livewire('notifications')

        @livewireScripts
        @filamentScripts
    </body>
</html>

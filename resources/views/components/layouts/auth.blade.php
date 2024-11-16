<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" type="image/png" href="{{ Vite::asset('resources/panel/images/favicon.png') }}">

        @livewireStyles
        @vite(['resources/panel/sass/auth.scss'])
        <script src='https://www.google.com/recaptcha/api.js?onload=handle&render=explicit' async defer></script>
    </head>
    <body>
        <div id="content_main" class="h-100">
            {{ $slot }}
        </div>
    </body>

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
   
</html>

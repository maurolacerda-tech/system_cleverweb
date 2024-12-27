<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" type="image/png" href="{{ Vite::asset('resources/panel/images/favicon.png') }}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        @livewireStyles
        @vite(['resources/panel/sass/app.scss'])
    </head>
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled" >
        

		<livewire:components.loader-manager lazy="on-load" />


        <div class="d-flex flex-column flex-root" >
			<div class="page d-flex flex-row flex-column-fluid">
                <livewire:panel.components.side />
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				
					<div class="content d-flex flex-column flex-column-fluid" id="app">
					
						{{ $slot }}

					</div>
                    <livewire:panel.components.footer />
				</div>
			</div>
			
		</div>
		<div class="drawer-overlay" id="drawer-overlay" style="display: none; z-index: 99" onclick="window.open_close_menu_mobile();"></div>
		<div class="drawer-overlay" id="drawer-overlay-top" style="display: none; z-index: 99" onclick="window.open_close_menutop();"></div>
    </body>

    @livewireScripts
	
    @vite(['resources/panel/js/app.js'])
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
	
</html>

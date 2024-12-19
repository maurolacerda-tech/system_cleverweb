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
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        

		<livewire:components.loader-manager lazy="on-load" />


        <div class="d-flex flex-column flex-root" >
			<div class="page d-flex flex-row flex-column-fluid">

                <livewire:panel.components.side />

				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<div id="kt_header" style="" class="header align-items-stretch">
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<livewire:panel.components.topbtnmobile />
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                                <livewire:panel.components.topmenu />

                                <livewire:panel.components.topbar />
							</div>							
						</div>
					</div>
					<div class="content d-flex flex-column flex-column-fluid" id="app">
					
						{{ $slot }}

					</div>
                    <livewire:panel.components.footer />
				</div>
			</div>
			
		</div>
		<div class="drawer-overlay" id="drawer-overlay" style="display: none; z-index: 99" onclick="window.open_close_menu();"></div>
		<div class="drawer-overlay" id="drawer-overlay-top" style="display: none; z-index: 99" onclick="window.open_close_menutop();"></div>
    </body>

    @livewireScripts
	
    @vite(['resources/panel/js/app.js'])
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
	
</html>

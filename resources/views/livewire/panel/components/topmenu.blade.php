<div class="d-flex align-items-stretch" id="kt_header_nav">
    <div class="header-menu align-items-stretch @if($menutop_is_open) drawer drawer-end drawer-on @endif" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend">
        
        <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
            <div class="menu-item me-lg-1">
                <a class="menu-link py-3" href="{{route('panel.dashboard')}}" wire:navigate>
                    <span class="menu-title">Dashboard</span>
                </a>
                
            </div>
            
        </div>

    </div>
</div>




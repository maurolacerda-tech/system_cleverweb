<div class="d-flex align-items-stretch flex-shrink-0">
    <div class="d-flex align-items-stretch flex-shrink-0">
        <div class="d-flex align-items-center ms-1 ms-lg-3" id="notification_app">
            <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                
                <span class="svg-icon svg-icon-1">
                    <span class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-primary">0</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black"/>
                        <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black"/>
                    </svg>
                </span>
                
            </div>
            
            <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" style="z-index: 105; position: fixed; inset: 0px 0px auto auto;margin: 0px;transform: translate(-30px, 65px);">
                
                <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{ Vite::asset('resources/panel/images/pattern-1.jpg') }}')">                    
                    <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notificações
                </div>
                
                <div class="tab-content">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                        <!--begin::Items-->
                        <div class="scroll-y mh-325px my-5 px-8">                            
                                                       
                            <div class="d-flex flex-stack py-4 d-none" >
                                <!--begin::Section-->
                                <div class="d-flex align-items-center">
                                    
                                    <div class="symbol symbol-35px me-4">
                                        <span class="'symbol-label bg-light-'">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                            <span class="'svg-icon svg-icon-2 svg-icon-'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black" />
                                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black" />
                                                </svg>
                                            </span>
                                            
                                        </span>
                                    </div>
                                    
                                    
                                    <div class="mb-0 me-2">
                                        <a href="javascript:void(0);" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Título aqui</a>
                                        <div class="text-gray-400 fs-7">Conteúdo aqui</div>

                                        <a href="javascript:void(0);" class="pt-2" data-id="notification.id" v-on:click="markAsRead">marcar como visto</a>
                                    </div>
                                    
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-light fs-8">data aqui</span>
                                <!--end::Label-->
                            </div>                        
                            
                            <div class="py-4">
                                Nenhuma notificação
                            </div>
                            
                            
                            
                        </div>
                        
                        <!--begin::View more-->
                        <div class="py-3 text-center border-top" v-if="notification_count > 0">
                            <a href="javascript:void(0);" class="btn btn-color-gray-600 btn-active-color-primary" v-on:click="markAsReadAll" >
                                Marcar todos como visto
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"/>
                                </svg>
                            </span>
                            </a>
                        </div>
                        <!--end::View more-->
                    </div>
                    <!--end::Tab panel-->
                   
                </div>
                
            </div>
            
        </div>
       
        <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
            <!--begin::Menu wrapper-->
            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="menu-perfil-top">
                <img src="@if(!is_null(auth()->user()->image)){{path_public_file('users/'.auth()->user()->image)}} @else {{ Vite::asset('resources/panel/images/user.png') }} @endif" alt="{{auth()->user()->name}}" />
            </div>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true" style="z-index: 105; position: fixed; inset: 0px 0px auto auto;margin: 0px;transform: translate(-30px, 65px);">              
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <div class="symbol symbol-50px me-5">
                            <img alt="{{auth()->user()->name}}" src="@if(!is_null(auth()->user()->image)){{path_public_file('users/'.auth()->user()->image)}} @else {{ Vite::asset('resources/panel/images/user.png') }} @endif" />
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fw-bolder d-flex align-items-center fs-5">{{auth()->user()->name}}</div>
                            <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{auth()->user()->email}}</a>
                        </div>
                    </div>
                </div>
                <div class="separator my-2"></div>
                <div class="menu-item px-5">
                    <a href="{{route('panel.users.edit',['user'=>auth()->user()->id])}}" class="menu-link px-5" wire:navigate>
                        Meu Perfil
                    </a>
                </div>
                <div class="menu-item px-5">
                    <a href="javascript:void(0);" class="menu-link px-5" wire:click="logout();">
                        Sair
                    </a>
                </div>               
            </div>
        </div>
        <!--end::User -->
        <!--begin::Heaeder menu toggle-->
        <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="black" />
                        <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="black" />
                    </svg>
                </span>
                
            </div>
        </div>
        <!--end::Heaeder menu toggle-->
    </div>
    <!--end::Toolbar wrapper-->
</div>
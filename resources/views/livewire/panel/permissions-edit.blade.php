<div>
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{$page_title ?? ''}}</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <h2 class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    {!! $page_subtitle ?? '' !!}
                </h2>
            </div>							
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">

        <div class="container-xxl">
            <form novalidate="novalidate" wire:submit="store">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_plan_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_plan_header" data-kt-scroll-wrappers="#kt_modal_add_plan_scroll" data-kt-scroll-offset="300px">
                            @include('livewire.panel.includes.permission-form')
                        </div>
                    </div>
                </div>
                

                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <a href="{{route('panel.permissions')}}" class="btn btn-flex btn-light btn-active-primary fw-bolder me-5" wire:navigate>
                        <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="black"></rect>
                                <path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="black"></path>
                            </svg>
                        </span>
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-warning" data-kt-users-modal-action="submit" id="btn_add_plan" wire:loading.attr="disabled">
                        <span class="indicator-label" wire:loading.remove>Salvar</span>
                        <span class="indicator-progress" wire:loading>Por favor aguarde...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        
    </div>


</div>

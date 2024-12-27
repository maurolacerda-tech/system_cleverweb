<div>
    <div class="header" id="kt_header">
        <div class="container-xxl d-flex align-items-center justify-content-between">
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0">
                <h1 class="text-dark fw-bolder my-0 fs-2">{{$page_title ?? ''}}</h1>
                @if(isset($page_subtitle) && is_array($page_subtitle))
                <ul class="breadcrumb fw-bold fs-base my-1">
                    @foreach ($page_subtitle as $subtitle_item)
                        <li class="breadcrumb-item {{$subtitle_item['class']}}">
                            @if(isset($subtitle_item['url']))
                                <a href="{{$subtitle_item['url']}}" class="{{$subtitle_item['class']}}" wire:navigate>{{$subtitle_item['name']}}</a>
                            @else
                                {{$subtitle_item['name']}}
                            @endif
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <livewire:panel.components.topbtnmobile />
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
                            @include('livewire.panel.includes.user-form')
                        </div>
                    </div>
                </div>
                

                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <a href="{{route('panel.users')}}" class="btn btn-flex btn-light btn-active-primary fw-bolder me-5" wire:navigate>
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

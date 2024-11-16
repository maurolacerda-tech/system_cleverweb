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
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title">
                        <span class="card-label fw-bolder fs-3 mb-1">&nbsp;</span>                    
                    </h3>
                    <div class="card-toolbar">
                        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-primary" wire:click="install_modules()">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                </svg>
                            </span> 
                            {{$btn_get_modules}}
                        </a>
                    </div>
                </div>            
            </div>

            @foreach ($all_modules as $type => $all_modules_list)
            <h6 class="my-4">{{$type}}</h6>
            <div class="row mt-4">
                @foreach ($all_modules_list as $key => $value)     
                @php
                    $nameMin = strtolower($key);
                    $path_image = get_image_base64('../modules/'.config($nameMin.'.type').'/'.$key.'/'.$nameMin.'.jpg');
                @endphp
                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card p-3">
                        <div class="card-blog card-plain">
                            <div class="position-relative">
                                <a class="d-block shadow-xl border-radius-xl">
                                <img src="{!! $path_image !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                </a>
                            </div>
                            <div class="card-body px-1 pb-0 text-center">
                                <p class="text-gradient text-dark mb-2 text-sm">{{config($nameMin.'.type')}} </p>
                                <a href="javascript:;">
                                    <h5>{{config($nameMin.'.label')}}</h5>
                                </a>
                                <div class="text-center align-items-center justify-content-between">
                                    @if (!is_null(config($nameMin.'.config')))
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light-primary btn-active-primary my-2" data-bs-toggle="modal" data-bs-target="#ConfigModuleModal{{$nameMin}}">
                                            <i class="fa fa-cog fs-6"></i>
                                            Configurar
                                        </a>
                                        @include('livewire.panel.includes._modules_modal_config')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach


        </div>
    </div>

</div>

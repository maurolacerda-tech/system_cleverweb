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
        <div id="kt_content_container" class="container-xxl">

            <div class="card ">
                <div class="card-header card-header-stretch">
                    <h3 class="card-title">Configurações</h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            @foreach ($config_array as $keyAbas => $valueAbas)
                            <li class="nav-item">
                                <a class="nav-link @if($keyAbas=='general') active @endif" data-bs-toggle="tab" href="#tab-{{ $keyAbas }}">
                                    {{ $valueAbas['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @foreach ($config_array as $keyAbas => $valueAbas)
                        <div class="tab-pane fade @if($keyAbas=='general') show active @endif " id="tab-{{ $keyAbas }}" role="tabpanel">
                            <div class="wrapper-md">
                                <form novalidate="novalidate" wire:submit="store">
                                    <div class="row">
                                        @foreach ($valueAbas['fields'] as $fields)
                                            <div class="{{ $fields['class_box'] ?? 'col-sm-6' }}">
                                                @include('livewire.panel.includes._fields')
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span class="indicator-label" wire:loading.remove>Atualizar</span>
                                        <span class="indicator-progress" wire:loading>Por favor aguarde...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

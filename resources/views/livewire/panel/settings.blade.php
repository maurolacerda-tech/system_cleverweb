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

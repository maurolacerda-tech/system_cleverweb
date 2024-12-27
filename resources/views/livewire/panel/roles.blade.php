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
    
            <div class="card mb-5">
                <div class="card-body border-0 pt-6">
                    <form wire:submit="search" class="position-relative my-1 w-100">
                        <div class="row">
                            <div class="col-sm-5 pb-3">
                                <div class="d-flex align-items-center">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                        </svg>
                                    </span>
                                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid ps-14" placeholder="Pesquisar" wire:model="search_label" />
                                </div>
                            </div>
                            
                            <div class="col-sm-2 pb-3 text-end">
                                <button type="submit"  class="btn btn-warning"  >
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                        </svg>
                                    </span>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    
            <div class="card">
    
                <div class="card-header border-0 pt-6">
                    <div class="card-title"> &nbsp; </div>
                    <div class="card-toolbar">
                        @can('manager_system_add_roles')
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base" x-data="{ openCreateRegister: false }" x-cloak>                       
                                <a href="javascript:void(0);"  type="button" class="btn btn-primary" @click="openCreateRegister = ! openCreateRegister" >
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    Adicionar
                                </a>
                                
                                <div class="modal modal-block" x-show="openCreateRegister">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <form  novalidate="novalidate" wire:submit="store">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Adicionar</h5>
                                                    <button type="button" class="btn-close" @click="openCreateRegister = ! openCreateRegister"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @include('livewire.panel.includes.role-form')
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_close_modal_add" class="btn btn-secondary" @click="openCreateRegister = ! openCreateRegister">Fechar</button>
                                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-warning" wire:loading.attr="disabled">
                                                        <span class="indicator-label" wire:loading.remove>Salvar</span>
                                                        <span wire:loading>Por favor aguarde...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        @endcan
                    </div>
                </div>
                
                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Grupos de Trabalho</th>
                                    <th class="text-end min-w-100px" width="100">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($roles as $role)
                                <tr wire:key="list_item_{{$role->id}}">
                                    <td class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            @can('manager_system_edit_roles')
                                                <a href="{{route('panel.roles.edit',['role'=>$role->id])}}" class="text-gray-800 text-hover-primary mb-1 d-inline-block" wire:navigate>
                                                    {{$role->label}} 
                                                </a>
                                            
                                                <i class="small">
                                                    {{$role->name}} 
                                                </i>
                                            @else
                                                <span class="text-gray-800 text-hover-primary mb-1 d-inline-block">
                                                    {{$role->label}} 
                                                </span>
                                            
                                                <i class="small">
                                                    {{$role->name}} 
                                                </i>
                                            @endcan
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Ações
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown position-absolute menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">                                       

                                            @can('manager_system_edit_roles')
                                            <div class="menu-item px-3">
                                                <a href="{{route('panel.roles.edit',['role'=>$role->id])}}" class="menu-link px-3" wire:key="edit_{{$role->id}}" wire:navigate>
                                                    Editar
                                                </a>
                                            </div>
                                            @endcan

                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="text-danger menu-link px-3" wire:click="delete_item({{$role->id}})" wire:confirm="Tem certeza que deseja excluír este registro? Esta ação não poderá ser desfeita!" wire:key="status_{{$role->id}}">
                                                    <i class="fa fa-times text-danger me-1"></i>
                                                    Excluir
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
    
                </div>
                
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

</div>

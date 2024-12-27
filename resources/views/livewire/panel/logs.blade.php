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
                            <div class="col-sm-6 pb-3">
                                <select name="query_users_filters" id="query_users_filters" class="form-select form-select-solid ps-5" wire:model="query_users_filters">
                                    <option value="">Filtrar por Usuários que causaram o evento</option>
                                    @foreach ($users_list as $user_item)
                                        <option value="{{$user_item->id}}">{{$user_item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-2 pb-3 text-end">
                                <button type="submit"  class="btn btn-warning w-100"  >
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
                        &nbsp;
                    </div>
                </div>
                
                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Log</th>
                                    <th class="min-w-125px">Antes</th>
                                    <th class="min-w-125px">Depois</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($logs as $log)
                                <tr wire:key="list_item_{{$log->id}}">

                                    <td class="align-items-center">
                                        <h3>{{$log->description}}</h3>
                                        <div>
                                            <i>
                                                <strong>Evento:</strong> {{$log->event}}
                                            </i>
                                        </div>
                                        <div>
                                            <i>
                                                <strong>Data:</strong> {{date('d/m/Y H:i', strtotime($log->created_at))}}
                                            </i>
                                        </div>
                                        <div>
                                            <i>
                                                <strong>Quem executou:</strong> {{$log->causer->name}}
                                            </i>
                                        </div>
                                        <div>
                                            <i>
                                                <strong>Onde executou:</strong> {{$log->subject_type}} @if(!is_null($log->subject_id)) {{$log->subject_id}} @endif
                                            </i>
                                        </div>
                                    </td>

                                    <td>
                                        @if(isset($log->changes) && !is_null($log->changes))
                                        <div>
                                            @php
                                                $old_changes = json_decode($log->changes) ?? [];
                                            @endphp
                                            @if(isset($old_changes->old))
                                            <ul>
                                                @foreach ($old_changes->old as $key => $old_item)
                                                    @if(!is_null($old_item))
                                                    <li>
                                                        <strong>{{$key}}:</strong> {{$old_item}}
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($log->changes) && !is_null($log->changes))
                                        <div>
                                            @php
                                                $new_changes = json_decode($log->changes) ?? [];
                                            @endphp
                                            @if(isset($new_changes->attributes))
                                            <ul>
                                                @foreach ($new_changes->attributes as $key => $new_item)
                                                    @if(!is_null($new_item))
                                                    <li>
                                                        <strong>{{$key}}:</strong> {{$new_item}}
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="dataTables_paginate paging_simple_numbers" id="kt_table_logs_paginate">
                                {{ $logs->links() }}
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

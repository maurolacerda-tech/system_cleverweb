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
    
</div>

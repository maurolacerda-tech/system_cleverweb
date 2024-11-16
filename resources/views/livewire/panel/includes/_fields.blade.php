@php
    $type = $fields['type'];
    $key = $fields['key'];
    $label = $fields['label'];
    $class = $fields['class'];
    $info = (isset($fields['info']) ? $fields['info'] : '' );

    $thisValue = (isset($setting[$key]) ? $setting[$key] : null );
@endphp
<div class="fv-row mb-7">
    <label for="{{$key}}" class="fw-bold fs-6 mb-2">{{$label}}</label>
    @if ($type == 'select')
        @php
            $list_field = $fields['option'];
        @endphp
        <select type="{{$type}}" name="{{$key}}" id="{{$key}}" value="{{$thisValue}}" class="{{$class}} form-select" wire:model='setting_fields.{{ $key }}'>
            <option value="">Selecione</option>
            @foreach ($list_field as $item_key => $item_value)
                <option value="{{$item_key}}" @if($thisValue == $item_key) selected @endif >{{$item_value}}</option>
            @endforeach
        </select>
    @elseif($type == 'multiple')
        @php
            $list_field = $fields['option'];
        @endphp
        <select type="{{$type}}" name="{{$key}}" id="{{$key}}" value="{{$thisValue}}" class="{{$class}} form-select" multiple wire:model='setting_fields.{{ $key }}'>
            <option value="">Selecione</option>
            @foreach ($list_field as $item_key => $item_value)
                <option value="{{$item_key}}" @if(in_array($item_key, $thisValue)) selected @endif >{{$item_value}}</option>
            @endforeach
        </select>
    @elseif($type == 'upload_image')
        <div class="row">
            <div class="col-sm-9">
                <input type="file" name="{{$key}}" id="{{$key}}" class="{{$class}}" wire:model='setting_fields.{{ $key }}'>
            </div>
            <div class="col-sm-3">
                @if(!is_null($thisValue))
                    <img src="{{$thisValue}}" alt="{{$key}}" class="img-fluid">
                @endif
            </div>
        </div>
    @elseif($type == 'krypt')
        <input type="text" name="{{$key}}" id="{{$key}}" class="{{$class}}" wire:model='setting_fields.{{ $key }}'>
    @elseif($type == 'password')
        <input type="password" name="{{$key}}" id="{{$key}}" class="{{$class}}" wire:model='setting_fields.{{ $key }}'>
    @elseif($type == 'editor')
        <textarea name="{{$key}}" id="{{$key}}" class="{{$class}} html-editor" wire:model='setting_fields.{{ $key }}'>{{$thisValue}}</textarea>
    @else
        <input type="{{$type}}" name="{{$key}}" id="{{$key}}" class="{{$class}}" wire:model='setting_fields.{{ $key }}'>
    @endif

</div>
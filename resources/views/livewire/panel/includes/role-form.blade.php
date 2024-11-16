<div class="row">
    <div class="col-sm-12">
        <div class="fv-row mb-7">
            <label for="label" class="required fw-bold fs-6 mb-2">Título de identificação</label>
            <input type="text" name="label" class="form-control form-control-solid mb-3 mb-lg-0" maxlength="191" wire:model="label">
            @error('label')
                <div class="text-danger pt-1 small">
                    <i class="fa fa fa-times-circle text-danger"></i>
                    {{ $message }} 
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="fv-row mb-7">
            <label for="name" class="required fw-bold fs-6 mb-2">Tag do time</label>
            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" maxlength="191" wire:model="name">
            @error('name')
                <div class="text-danger pt-1 small">
                    <i class="fa fa fa-times-circle text-danger"></i>
                    {{ $message }} 
                </div>
            @enderror
        </div>
    </div>
</div>

<label class="fw-bold fs-6 mb-5 d-block">
    Unidades/Franquias
    <a href="javascript:void(0);" class="float-end small" id="mark_all" wire:click="select_all"> marcar todos</a>
</label>

<div class="mb-7 fv-row row">
    @php
        $group_name = '';
    @endphp
    @foreach ($permissions as $permission)
    @if ($permission->group_name != $group_name)
        @php
            $group_name = $permission->group_name;
        @endphp
        <div class="col-lg-12">
            <h5 class="py-3">{{$group_name}}</h5>
        </div>
    @endif
    <div class="col-lg-6 col-md-6">
        <div class="form-check form-check-custom form-check-solid">
            <input type="checkbox" name="permission_id[]" id="kt_modal_update_role_option_{{$permission->id}}" value="{{$permission->id}}" class="form-check-input me-3 check_select_item_class" wire:model="permission_id">
            <label class="form-check-label" for="kt_modal_update_role_option_{{$permission->id}}">
                <div class="fw-bolder text-gray-800">{{$permission->label}}</div>
            </label>
        </div>
        <div class='separator separator-dashed my-5'></div>
    </div>
    @endforeach
    @error('permission_id')
        <div class="text-danger pt-1 small">
            <i class="fa fa fa-times-circle text-danger"></i>
            {{ $message }} 
        </div>
    @enderror
</div>
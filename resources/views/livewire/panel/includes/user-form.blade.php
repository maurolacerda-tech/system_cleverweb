<div class="row">
    <div class="col-sm-8">
        <div class="fv-row mb-7">
            <div
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <label for="image_field" class="fw-bold fs-6 mb-2">Foto</label>
                <input type="file" id="image_field" class="form-control form-control-solid mb-3 mb-lg-0" wire:model="image">
                @error('image')
                    <div class="text-danger pt-1 small">
                        <i class="fa fa fa-times-circle text-danger"></i>
                        {{ $message }} 
                    </div>
                @enderror
                <div x-show="uploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        @if ($image)
             <img src="{{ $image->temporaryUrl() }}" class="h-70px">
        @else
            @if (!is_null($image_show))
                <img src="{{ path_public_file("storage/users/".$image_show) }}" class="h-70px">
            @endif
        @endif
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="fv-row mb-7">
            <label for="name" class="fw-bold fs-6 mb-2">Nome</label>
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

<div class="row">
    <div class="col-sm-12">
        <div class="fv-row mb-7">
            <label for="email" class="fw-bold fs-6 mb-2">E-mail</label>
            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" maxlength="191" wire:model="email">
            @error('email')
                <div class="text-danger pt-1 small">
                    <i class="fa fa fa-times-circle text-danger"></i>
                    {{ $message }} 
                </div>
            @enderror
        </div>
    </div>
    
</div>



<div class="row">
    <div class="col-sm-8">
        <div class="fv-row mb-7" data-kt-password-meter="true">
            <label for="password" class="fw-bold fs-6 mb-2">Senha</label>
            <div class="position-relative mb-3">
                <input class="form-control form-control-solid mb-3 mb-lg-0" name="password" type="password" value="" id="password" wire:model="password">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="fv-row mb-7">
            <div class="fv-row mb-7">
                <label for="status" class="fw-bold fs-6 mb-2">Status</label>
                <div class="form-check form-switch form-switch form-check-custom form-check-solid">                                        
                    <input class="form-check-input w-50px" name="status" @if(isset($user) && $user->status) checked="checked" @endif type="checkbox" wire:model="status" />
                </div>
                @error('status')
                    <div class="text-danger pt-1 small">
                        <i class="fa fa fa-times-circle text-danger"></i>
                        {{ $message }} 
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>

@if(
    (auth()->user()->can('manager_system_edit_users') && isset($user)) ||
    (auth()->user()->can('manager_system_add_users') && !isset($user))
)
    <label class="fw-bold fs-6 mb-5 d-block">
        Equipes
        <a href="javascript:void(0);" class="float-end small" id="mark_all" wire:click="select_all"> marcar todos</a>
    </label>

    <div class="mb-7 fv-row row">
        
        @foreach ($roles as $role)
    
        <div class="col-lg-6 col-md-6">
            <div class="form-check form-check-custom form-check-solid">
                <input type="checkbox" name="role_id[]" id="kt_modal_update_role_option_{{$role->id}}" value="{{$role->id}}" class="form-check-input me-3 check_select_item_class" wire:model="role_id">
                <label class="form-check-label" for="kt_modal_update_role_option_{{$role->id}}">
                    <div class="fw-bolder text-gray-800">{{$role->label}}</div>
                </label>
            </div>
            <div class='separator separator-dashed my-5'></div>
        </div>
        @endforeach
        @error('role_id')
            <div class="text-danger pt-1 small">
                <i class="fa fa fa-times-circle text-danger"></i>
                {{ $message }} 
            </div>
        @enderror
    </div>
@endif


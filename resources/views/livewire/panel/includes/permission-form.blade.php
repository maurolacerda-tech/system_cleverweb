<div class="row">
    <div class="col-sm-12">
        <div class="fv-row mb-7">
            <label for="group_name" class="required fw-bold fs-6 mb-2">Grupo</label>
            <select type="text" name="group_name" class="form-select form-select-solid mb-3 mb-lg-0" wire:model="group_name">
                <option value="">Selecione</option>
                @foreach ($group_list as $group_key => $group_value)
                    <option value="{{$group_key}}">{{$group_value}}</option>
                @endforeach
            </select>
            @error('group_name')
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
            <label for="name" class="required fw-bold fs-6 mb-2">Código da Permissão</label>
            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" wire:model="name">
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
            <label for="company_name" class="required fw-bold fs-6 mb-2">Título de Identificação</label>
            <input type="text" name="label" class="form-control form-control-solid mb-3 mb-lg-0" wire:model="label">
            @error('label')
                <div class="text-danger pt-1 small">
                    <i class="fa fa fa-times-circle text-danger"></i>
                    {{ $message }} 
                </div>
            @enderror
        </div>
    </div>
</div>
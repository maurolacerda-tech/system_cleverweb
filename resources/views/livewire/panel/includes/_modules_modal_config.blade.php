<div class="modal fade text-start" id="ConfigModuleModal{{$nameMin}}" tabindex="-1" role="dialog" aria-labelledby="ModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form novalidate="novalidate" wire:submit="store">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ $key }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body" style="width: 100%">
                    @php
                        $valueAbas = config($nameMin.'.config');
                    @endphp
                    <div class="row text-left">
                        @foreach ($valueAbas['fields'] as $fields)
                            <div class="col-sm-12">
                                @include('livewire.panel.includes._fields')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:click="setting_fields.source_form_module='{{$nameMin}}.config'">
                        <span class="indicator-label" wire:loading.remove>Atualizar</span>
                        <span class="indicator-progress" wire:loading>Por favor aguarde...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
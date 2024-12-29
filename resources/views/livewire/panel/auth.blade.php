<div class="h-100">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid h-100">
        <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative d-none d-xl-flex" >
            <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px bgi-no-repeat bgi-position-y-bottom" style="background-image: url({{ Vite::asset('resources/panel/images/login-bg.webp') }});background-size: auto 100%; background-color:#04c8c8">
                <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20 d-none">
                    <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #EC684E;">
                        Painel Gerenciador
                    </h1>
                    <p class="fw-bold fs-2 d-none" style="color: #042637;">
                        Painel administrativo Principal
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" wire:submit="store">
                        @csrf
                        <div class="text-center mb-10">
                            <a href="" class="py-9 mb-5">
                                <img alt="{{config('app.name')}}" src="{{ Vite::asset('resources/panel/images/logo.jpg') }}" class="h-70px" />
                                <img alt="{{config('app.name')}}" src="{{ Vite::asset('resources/panel/images/logo.jpg') }}" class="h-50px d-none" />
                            </a>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">E-mail</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" wire:model="email" />
                            @error('email')
                                <div class="text-danger pt-1 small">
                                    <i class="fa fa fa-times-circle text-danger"></i>
                                    {{ $message }} 
                                </div>
                            @enderror
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Senha</label>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password" autocomplete="off" wire:model="password" />
                            @error('password')
                                <div class="text-danger pt-1 small">
                                    <i class="fa fa fa-times-circle text-danger"></i>
                                    {{ $message }} 
                                </div>
                            @enderror
                        </div>
                        <div class="fv-row mb-10" >
                            <div id="captcha" wire:ignore></div>
                            @error('captcha')
                                <div class="text-danger pt-1 small">
                                    <i class="fa fa fa-times-circle text-danger"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-center" x-data="msgerr">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" x-on:click="clean_captcha" wire:loading.attr="disabled">
                                <span class="indicator-label" wire:loading.remove>Entrar</span>
                                <span wire:loading>Por favor aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
    
                </div>
                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                    <div class="d-flex flex-center fw-bold fs-6">
                        <a href="https://cleverweb.com.br/servicos/sistemas-web" class="text-muted text-hover-gray-700 px-2 small" title="desenvolvimento de sistemas web" target="_blank">
                            <img src="{{ Vite::asset('resources/panel/images/favicon.png') }}" alt="Sistemas Web" width="20" height="20"> by Clever Web
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var  handle = function(e) {
        widget = grecaptcha.render('captcha', {
            'sitekey': '{{config("auth.captcha_key")}}',
            'theme': 'light', // you could switch between dark and light mode.
            'callback': verify
        });
 
    }
    var verify = function (response) {
        @this.set('captcha', response)
    }
</script>

@script
<script>

    //clean_captcha
    Alpine.data('msgerr', () => {
        return {
            count: 0,
            clean_captcha() {
                setTimeout(() => {
                    grecaptcha.reset();
                }, 500);
            },
        }
    })
</script>
@endscript


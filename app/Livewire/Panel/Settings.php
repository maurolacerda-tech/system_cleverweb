<?php

namespace App\Livewire\Panel;

use App\Helpers\SettingHelpers;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Settings extends Component
{
    use LivewireAlert;
    
    public $page_title = 'Configurações';
    public $page_subtitle = 'Configurações - Geral';
    public $config_array;
    public $setting_fields = [];

    public function mount()
    {   
        $config_array = config('setting.setting');
        $this->config_array = $config_array;

        $settings = SettingHelpers::getList();
        
        foreach ($config_array as $config_groups) {
            foreach ($config_groups['fields'] as $fields) {
                $keys_name = (isset($fields['key']) ? $fields['key'] : null );
                $thisValue = $settings[$keys_name] ?? null;
                $field_type = $fields['type'];
                switch ($field_type) {
                    case 'multiple':
                        $thisValue = (!is_null($thisValue) ? explode(',',$thisValue) : [] );
                        break;
                    case 'krypt':
                        if(!is_null($thisValue)){
                            $thisValue = dekriptar($thisValue);
                        }
                        break;
                }
                $this->setting_fields[$keys_name] = $thisValue;
            }
        }
    }


    public function render()
    {
        if( Gate::denies("manager_system_settings") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        return view('livewire.panel.settings');
    }

    public function store()
    {
        if( Gate::denies("manager_system_settings") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $dataForm = $this->setting_fields;
        $setting = new SettingHelpers;
        $setting->save_values($dataForm);
        $this->alert('success', 'Atualizado com sucesso!',['timer' => '6000']);
    }
}

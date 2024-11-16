<?php

namespace App\Livewire\Panel;

use App\Helpers\ModulesHelpers;
use App\Helpers\SettingHelpers;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Integrations extends Component
{
    use LivewireAlert;

    public $page_title = 'Integrações e Plugins';
    public $page_subtitle = 'Configurações - Integrações e Plugins';
    public $all_modules;
    public $setting_fields = [];
    public $btn_get_modules = 'Verificar se há novos módulos';

    public function search()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $modules = new ModulesHelpers;

        $get_all_modules = $modules->get_all_modules();
        $get_modules_config = $modules->get_modules_config();
        $all_modules = array_intersect_key($get_all_modules, $get_modules_config);

        $this->all_modules = $all_modules;

        $settings = SettingHelpers::getList();

        foreach ($all_modules as $type => $all_modules_list){
            foreach ($all_modules_list as $key => $value) {
                $nameMin = strtolower($key);
                $valueAbas = config($nameMin.'.config');
                foreach ($valueAbas['fields'] as $fields) {
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
    }

   

    public function render()
    {
        if( Gate::denies("manager_system_integrations") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        return view('livewire.panel.integrations');
    }

    public function store()
    {
        if( Gate::denies("manager_system_integrations") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');
        $dataForm = $this->setting_fields;
        $setting = new SettingHelpers;
        $setting->save_values($dataForm);
        
        return $this->redirectRoute('panel.integrations', navigate: true);
    }

    public function install_modules()
    {   
        $rejects = ['.','..','...',' ','.php'];
        $dir_modules = dir('../modules');
        $date_now = date('d/m/Y H:i');

        $conteudo = '<?php'.chr(13);
        $conteudo .= '// arquivo gerado pelo sistema '. $date_now.' '.chr(13);
        $conteudo .= 'return ['.chr(13);
        while($type_module = $dir_modules -> read()){
            if(!in_array($type_module, $rejects)){
                $modules = dir('../modules/'.$type_module.'');
                while($module = $modules->read()){
                    $dir_provider = @dir('../modules/'.$type_module.'/'.$module.'/Providers') ?? null;
                    if($dir_provider){
                        while($file_provider = $dir_provider->read()){
                            if(!in_array($file_provider, $rejects)){
                                $file_provider = str_replace('.php','',$file_provider);
                                $conteudo .= "  Modules\\$type_module\\$module\Providers\\$file_provider::class,".chr(13);
                            }
                        }
                    }                    
                }                             
            }            
        }
        $conteudo .= '];';

        $Arquivo = fopen('../config/_modules.php',"w");
        fwrite($Arquivo,"$conteudo\n");
        fclose($Arquivo);

        $process = new Process(['composer', 'dumpautoload', '--working-dir=../']);
        $process->setTimeout(null);

        try {
            $process->mustRun(); //echo '<code>'. $process->getOutput() .'</code>';
        } catch (ProcessFailedException $e) {
            dd($e->getMessage());
        }
        
        return $this->redirectRoute('panel.integrations', navigate: true);
    }
}

<?php

namespace App\Livewire\Panel;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Activitylog\Models\Activity;

class Logs extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $page_title = 'Logs';
    public $page_subtitle = [];

    public $query_users_filters;

    public function mount()
    {
        $this->page_subtitle = [
            [
                'name' => 'Gerenciamento',
                'class' => 'text-muted'
            ],
            [
                'name' => 'Perfis de acesso',
                'class' => 'text-muted'
            ],
            [
                'name' => 'Logs',
                'class' => 'text-dark',
                'url' => route('panel.logs')
            ]
        ];
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        if( Gate::denies("view_system_logs") ) 
            abort(403, 'Você não tem permissão para gerenciar esta página');

        $user_auth = Auth::user();
        /** @disregard [hasAnyRoles] [method in User Model] */
        $user_is_developer = $user_auth->hasAnyRoles('developer');

        $users_list = User::where(function($query) use($user_is_developer){
            $query->where('id','>',0);
            if(!$user_is_developer){
                $query->whereHas('roles', function($q){
                    $q->where('roles.id','<>',1);
                });
            }
        })->get();

        $query_users_filters = $this->query_users_filters;
        $logs = Activity::where('log_name','default')->where(function($query) use($user_is_developer, $query_users_filters){
            $query->where('id','>',0);
            if(!$user_is_developer){
                $query->whereHas('causer', function($q) use($query_users_filters){
                    $q->where('users.id','<>',1);
                    if(!is_null($query_users_filters) && !empty($query_users_filters) && is_numeric($query_users_filters)){
                        $q->where('users.id',$query_users_filters);
                    }
                });
            }else{
                if(!is_null($query_users_filters) && !empty($query_users_filters) && is_numeric($query_users_filters)){
                    $query->whereHas('causer', function($q) use($query_users_filters){
                        $q->where('users.id',$query_users_filters);
                    });
                }
            }
        })->orderBy('id','desc')->paginate(30);
        return view('livewire.panel.logs', compact('logs','users_list'));
    }
}

<?php

use App\Livewire\Panel\{
    Auth,
    Dashboard,
    Integrations,
    Logs,
    Permissions,
    PermissionsEdit,
    Roles,
    RolesEdit,
    Settings,
    Users,
    UsersEdit
};
use Illuminate\Support\Facades\Route;

Route::get('/', Auth::class)->name('panel.auth');

Route::middleware('auth')->group(function () {
    Route::get('/panel/dashboard', Dashboard::class)->name('panel.dashboard');

    Route::get('/panel/permissions', Permissions::class)->name('panel.permissions');
    Route::get('/panel/permissions/{permission}/edit', PermissionsEdit::class)->name('panel.permissions.edit');

    Route::get('/panel/roles', Roles::class)->name('panel.roles');
    Route::get('/panel/roles/{role}/edit', RolesEdit::class)->name('panel.roles.edit');

    Route::get('/panel/users', Users::class)->name('panel.users');
    Route::get('/panel/users/{user}/edit', UsersEdit::class)->name('panel.users.edit');

    Route::get('/panel/settings', Settings::class)->name('panel.settings');
    Route::get('/panel/integrations', Integrations::class)->name('panel.integrations');

    Route::get('/panel/logs', Logs::class)->name('panel.logs');
});
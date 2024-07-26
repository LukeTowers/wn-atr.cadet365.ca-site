<?php

namespace ACFP\Timesheets;

use Backend\Facades\Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * Timesheets Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'acfp.timesheets::lang.plugin.name',
            'description' => 'acfp.timesheets::lang.plugin.description',
            'author'      => 'ACFP',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {
    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'acfp.timesheets.some_permission' => [
                'tab' => 'acfp.timesheets::lang.plugin.name',
                'label' => 'acfp.timesheets::lang.permissions.some_permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return []; // Remove this line to activate

        return [
            'timesheets' => [
                'label'       => 'acfp.timesheets::lang.plugin.name',
                'url'         => Backend::url('acfp/timesheets/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['acfp.timesheets.*'],
                'order'       => 500,
            ],
        ];
    }
}

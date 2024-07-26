<?php

namespace ACFP\ATR;

use Backend\Facades\BackendMenu;
use Illuminate\Support\Facades\Request;
use System\Classes\PluginBase;
use Winter\Storm\Support\Facades\Config;

use ACFP\ATR\Models\Site as SiteModel;

/**
 * @TODO:
 * - Plan out functionality structure
 * - Filter the available fields based on the member "type" selected
 * - Implement auditing on the member records
 * - Add ability to tie member records to users (similar to CaptiveXM approach, except every user needs to have a member record)
 * - Plan out permissions structure
 */
class Plugin extends PluginBase
{
    public $elevated = true;

    public $require = [
        'Winter.Location',
    ];

    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'acfp.atr::lang.plugin.name',
            'description' => 'acfp.atr::lang.plugin.description',
            'author'      => 'Luke Towers',
            'icon'        => 'icon-plane',
            'homepage'    => 'https://atr.cadet365.ca',
        ];
    }

    public function boot()
    {
        if (!$this->app->hasDatabaseTable('acfp_atr_sites')) {
            return;
        }

        $baseHost = parse_url(Config::get('app.url'), PHP_URL_HOST);
        $targetHost = trim(str_replace($baseHost, "", Request::getHost()), '.');

        $targetSite = SiteModel::where('code', $targetHost)->first();

        if ($targetSite) {
            Config::set('brand.tagline', $targetSite->name);
        }

        BackendMenu::registerCallback(function ($manager) {
            $manager->removeMainMenuItem('Winter.Backend', 'media');
        });
    }
}

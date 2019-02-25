<?php namespace ACGP\FlyingSite;

use Config;
use Schema;
use Request;
use BackendMenu;
use System\Classes\PluginBase;

use ACGP\FlyingSite\Models\Site as SiteModel;

/**
 * @TODO:
 * - Plan out functionality structure
 * - Filter the available fields based on the member "type" selected
 * - Save the PEN Form information when the form is saved
 * - Generate a completed PDF with the PEN form data after saving the PEN FORM
 * - Require an update or verification of the PEN form every year
 * - Implement auditing on the member records
 * - Add ability to tie member records to users (similar to CaptiveXM approach, except every user needs to have a member record)
 * - Plan out permissions structure
 */
class Plugin extends PluginBase
{
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'acgp.flyingsite::lang.plugin.name',
            'description' => 'acgp.flyingsite::lang.plugin.description',
            'author'      => 'Air Cadet Gliding Program',
            'icon'        => 'icon-plane',
            'homepage'    => 'https://cadetflying.site',
        ];
    }

    public function boot()
    {
        if (!Schema::hasTable('acgp_flyingsite_sites')) {
            return;
        }

        $baseHost = parse_url(Config::get('app.url'), PHP_URL_HOST);
        $targetHost = trim(str_replace($baseHost, "", Request::getHost()), '.');

        $targetSite = SiteModel::where('code', $targetHost)->first();

        if ($targetSite) {
            Config::set('brand.tagline', $targetSite->name);
        }

        BackendMenu::registerCallback(function ($manager) {
            $manager->removeMainMenuItem('October.Backend', 'media');
        });
    }
}

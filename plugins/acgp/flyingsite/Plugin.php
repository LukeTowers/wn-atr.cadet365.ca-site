<?php namespace ACGP\FlyingSite;

use Config;
use Request;
use System\Classes\PluginBase;

use ACGP\FlyingSite\Models\Site as SiteModel;

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
        $baseHost = parse_url(Config::get('app.url'), PHP_URL_HOST);
        $targetHost = trim(str_replace($baseHost, "", Request::getHost()), '.');

        $targetSite = SiteModel::where('code', $targetHost)->first();

        if ($targetSite) {
            Config::set('brand.tagline', $targetSite->name);
        }
    }
}

<?php namespace ACGP\FlyingSite\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Regions Back-end Controller
 */
class Regions extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('ACGP.FlyingSite', 'acgp-regions');
    }
}

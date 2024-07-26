<?php

namespace ACFP\ATR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Sites Back-end Controller
 */
class Sites extends Controller
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

        BackendMenu::setContext('acfp.atr', 'acgp-sites');
    }
}

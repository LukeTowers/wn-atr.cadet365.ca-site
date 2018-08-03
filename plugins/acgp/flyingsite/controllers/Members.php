<?php namespace ACGP\FlyingSite\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Members extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $bodyClass = 'compact-container';

    public $requiredPermissions = [
        'manage_members'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ACGP.FlyingSite', 'acgp-members');
    }
}

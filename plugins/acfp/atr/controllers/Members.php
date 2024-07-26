<?php

namespace ACFP\ATR\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Members extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class,
    ];

    public $bodyClass = 'compact-container';

    public $requiredPermissions = [
        'manage_members'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('acfp.atr', 'acgp-members');
    }
}

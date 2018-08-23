<?php namespace ACGP\FlyingSite\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Widgets\Form as FormWidget;

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


    /**
     * @var FormWidget The FormWidget instance used for the PEN form
     */
    protected $penFormWidget;

    /**
     * Initialize the PEN Form Widget
     * @param integer $memberId The ID of the member to initialize the PEN form for
     */
    protected function initPENForm($id)
    {
        if ($id) {
            $member = $this->formFindModelObject($id);
        } else {
            throw new \Exception("Member must exist first");
        }

        $config = $this->makeConfig("$/acgp/flyingsite/models/member/fields.pen_form.yaml");
        $config->model = $member;
        $config->arrayName = class_basename($member);
        $config->context = 'view';

        $this->penFormWidget = $this->makeWidget(FormWidget::class, $config);
        $this->penFormWidget->bindToController();
    }

    public function onLoadPENForm($id = null)
    {
        $this->initPENForm($id);

        $this->vars['penFormWidget'] = $this->penFormWidget;

        return $this->makePartial('form_pen');
    }
}

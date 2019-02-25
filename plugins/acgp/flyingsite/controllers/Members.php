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


    public function update($id)
    {
        $this->initPENForm($id);
        return $this->asExtension('FormController')->update($id);
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
        $member->pen_form->rules = $member->pen_form->penRules;
        $config->model = $member->pen_form;
        $config->arrayName = class_basename($member->pen_form);
        $config->context = 'view';

        $this->penFormWidget = $this->makeWidget(FormWidget::class, $config);
        $this->penFormWidget->bindToController();
        $this->vars['penFormWidget'] = $this->penFormWidget;
    }

    public function update_onLoadPENForm()
    {
        $this->pageAction();
        return $this->makePartial('form_pen');
    }

    public function update_onSavePENForm()
    {
        $this->pageAction();
        $data = $this->penFormWidget->getSaveData();
        $model = $this->penFormWidget->model;
        foreach ($data as $attribute => $value) {
            if (is_array($value)) {
                $value = array_merge((array) $model->{$attribute}, $value);
            }
            $model->{$attribute} = $value;
        }
        $model->save();
    }
}

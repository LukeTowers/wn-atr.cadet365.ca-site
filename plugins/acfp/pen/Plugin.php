<?php

namespace ACFP\PEN;

use Backend\Facades\Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * PEN Plugin Information File
 *
 * @TODO:
 * - Save the PEN Form information when the form is saved
 * - Generate a completed PDF with the PEN form data after saving the PEN FORM
 * - Require an update or verification of the PEN form every year
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'acfp.pen::lang.plugin.name',
            'description' => 'acfp.pen::lang.plugin.description',
            'author'      => 'ACFP',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {
        // @TODO: To add to Member model
        // public $hasOne = [
        //     'pen_form' => [PenForm::class],
        // ];

        // /**
        //  * @var FormWidget The FormWidget instance used for the PEN form
        //  */
        // protected $penFormWidget;

        // /**
        //  * Initialize the PEN Form Widget
        //  * @param integer $memberId The ID of the member to initialize the PEN form for
        //  */
        // protected function initPENForm($id)
        // {
        //     if ($id) {
        //         $member = $this->formFindModelObject($id);
        //     } else {
        //         throw new \Exception("Member must exist first");
        //     }

        //     $config = $this->makeConfig("$/acfp/atr/models/member/fields.pen_form.yaml");
        //     $member->pen_form->rules = $member->pen_form->penRules;
        //     $config->model = $member->pen_form;
        //     $config->arrayName = class_basename($member->pen_form);
        //     $config->context = 'view';

        //     $this->penFormWidget = $this->makeWidget(FormWidget::class, $config);
        //     $this->penFormWidget->bindToController();
        //     $this->vars['penFormWidget'] = $this->penFormWidget;
        // }

        // public function update_onLoadPENForm()
        // {
        //     $this->pageAction();
        //     return $this->makePartial('form_pen');
        // }

        // public function update_onSavePENForm()
        // {
        //     $this->pageAction();
        //     $data = $this->penFormWidget->getSaveData();
        //     $model = $this->penFormWidget->model;
        //     foreach ($data as $attribute => $value) {
        //         if (is_array($value)) {
        //             $value = array_merge((array) $model->{$attribute}, $value);
        //         }
        //         $model->{$attribute} = $value;
        //     }
        //     $model->save();
        // }
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'acfp.pen.some_permission' => [
                'tab' => 'acfp.pen::lang.plugin.name',
                'label' => 'acfp.pen::lang.permissions.some_permission',
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
            'pen' => [
                'label'       => 'acfp.pen::lang.plugin.name',
                'url'         => Backend::url('acfp/pen/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['acfp.pen.*'],
                'order'       => 500,
            ],
        ];
    }
}

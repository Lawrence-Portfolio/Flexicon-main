<?php namespace BizMark\Flexicon\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Print Types Back-end Controller
 */
class PrintTypes extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['bizmark.flexicon.access_types'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BizMark.Flexicon', 'flexicon', 'printtypes');
    }
}

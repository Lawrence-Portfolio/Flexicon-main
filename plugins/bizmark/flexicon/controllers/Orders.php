<?php namespace BizMark\Flexicon\Controllers;

use BackendMenu, Redirect, Backend;
use Backend\Classes\Controller;
use BizMark\Flexicon\Models\Order;

/**
 * Orders Back-end Controller
 */
class Orders extends Controller
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

    public $requiredPermissions = ['bizmark.flexicon.access_orders'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BizMark.Flexicon', 'flexicon-orders', 'orders');
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass($record, $definition = null)
    {
        $classes = [];

        if (!$record->is_read) {
            $classes[] = 'important frozen';
        }

        if (count($classes) > 0) {
            return join(' ', $classes);
        }
    }

    public function preview($recordId = null)
    {
        $this->setOrderRead($this->formFindModelObject($recordId));

        parent::preview($recordId);
    }

    public function update($recordId = null)
    {
        $this->setOrderRead($this->formFindModelObject($recordId));

        parent::update($recordId);
    }

    protected function setOrderRead($order)
    {
        $order->is_read = true;
        $order->save();
    }

}

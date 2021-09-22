<?php namespace BizMark\Flexicon;

use Backend;
use BizMark\Flexicon\Models\Order;
use System\Classes\PluginBase;

/**
 * Flexicon Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Flexicon',
            'description' => 'No description provided yet...',
            'author'      => 'BizMark',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'BizMark\Flexicon\Components\MakeOrder' => 'MakeOrder',
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'bizmark.flexicon::mail.order'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'bizmark.flexicon.access_types' => [
                'tab' => 'Flexicon',
                'label' => 'Управление информацией калькулятора'
            ],
            'bizmark.flexicon.access_orders' => [
                'tab' => 'Flexicon',
                'label' => 'Управление заказами'
            ],
            'bizmark.flexicon.access_settings' => [
                'tab' => 'Flexicon',
                'label' => 'Управление настройками'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'flexicon' => [
                'label'       => 'Flexicon',
                'url'         => Backend::url('bizmark/flexicon/boxnames'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bizmark.flexicon.access_types'],
                'order'       => 500,
                'sideMenu' => [
                    'boxnames' => [
                        'label'       => 'Название коробки',
                        'url'         => Backend::url('bizmark/flexicon/boxnames'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bizmark.flexicon.access_types'],
                        'order'       => 500,
                    ],
                    'boxtypes' => [
                        'label'       => 'Тип коробки',
                        'url'         => Backend::url('bizmark/flexicon/boxtypes'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bizmark.flexicon.access_types'],
                        'order'       => 500,
                    ],
                    'papernames' => [
                        'label'       => 'Названия картона',
                        'url'         => Backend::url('bizmark/flexicon/papernames'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bizmark.flexicon.access_types'],
                        'order'       => 500,
                    ],
                    'papertypes' => [
                        'label'       => 'Тип картона',
                        'url'         => Backend::url('bizmark/flexicon/papertypes'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bizmark.flexicon.access_types'],
                        'order'       => 500,
                    ],
                    'printtypes' => [
                        'label'       => 'Тип печати',
                        'url'         => Backend::url('bizmark/flexicon/printtypes'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bizmark.flexicon.access_types'],
                        'order'       => 500,
                    ],
                ]
            ],
            'flexicon-orders' => [
                'label'       => 'Заказы',
                'url'         => Backend::url('bizmark/flexicon/orders'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bizmark.flexicon.access_orders'],
                'order'       => 500,
                'counter'      => Order::getUnreadCount(),
                'counterLabel' => 'Новых заказов'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Настройки калькулятора',
                'description' => 'Управление коэфициентами, настройками',
                'category'    => 'Flexicon',
                'icon'        => 'icon-cog',
                'class'       => 'BizMark\Flexicon\Models\Settings',
                'order'       => 500,
                'keywords'    => 'calculator flexicon',
                'permissions' => ['bizmark.flexicon.access_settings']
            ]
        ];
    }
}

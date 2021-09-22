<?php namespace BizMark\Flexicon\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'bizmark_flexicon_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'margin' => 'required',
        'cost_prepress' => 'required',
        'cost_fee' => 'required',
        'cost_other' => 'required',
        'cost_cutting' => 'required',
        'cost_pack_10_50' => 'required',
        'cost_pack_51_100' => 'required',
        'cost_pack_101_200' => 'required',
        'cost_pack_201_300' => 'required',
        'cost_pack_301_500' => 'required',
        'cost_pack_501_more' => 'required',
    ];

    public $customMessages = [
        'margin.required' => 'Коэффициент "маржа" обязательна ',
        'cost_prepress.required' => '"Затраты на препресс" обязательно для заполнения',
        'cost_fee.required' => 'НДС обязательно для заполнения',
        'cost_other.required' => '"Прочие затраты" обязательно для заполнения',
    ];
}

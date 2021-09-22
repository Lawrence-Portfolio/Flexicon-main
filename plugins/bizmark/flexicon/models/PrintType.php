<?php namespace BizMark\Flexicon\Models;

use Model;

/**
 * PrintType Model
 * @package BizMark\Flexicon\Models;
 * @author Nick Khaetsky @ Biz-Mark, nick@biz-mark.ru, info@biz-mark.ru
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                       $id
 * @property boolean                   $name
 * @property float                     $price
 * @property float                     $coefficient
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 */
class PrintType extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bizmark_flexicon_print_types';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
        'price' => 'required',
        'coefficient' => 'required',
    ];

    public $customMessages = [
        'name.required' => 'Название обязательно для заполнения',
        'price.required' => 'Стоимость обязательна для заполнения',
        'coefficient.required' => 'Коэффициент обязателен для заполнения',
    ];
}

<?php namespace BizMark\Flexicon\Models;

use Model;
use System\Models\File;

/**
 * BoxType Model
 * @package BizMark\Flexicon\Models;
 * @author Nick Khaetsky @ Biz-Mark, nick@biz-mark.ru, info@biz-mark.ru
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                              $id
 * @property string                                           $code
 * @property float                                            $coefficient
 * @property \October\Rain\Argon\Argon                        $created_at
 * @property \October\Rain\Argon\Argon                        $updated_at
 *
 * Relation
 * @property int                                              $box_name_id
 * @property BoxName                                          $box_name
 * @method \October\Rain\Database\Relations\BelongsTo|BoxName box_name()
 *
 * @property File                                             $image
 * @method \October\Rain\Database\Relations\AttachOne|File    image()
 */
class BoxType extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bizmark_flexicon_box_types';

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
        'image',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'box_name' => 'required',
        'code' => 'required',
        'coefficient' => 'required',
    ];

    public $customMessages = [
        'box_name.required' => 'Название обязательно для заполнения',
        'code.required' => 'Артикул коробки обязателен для заполнения',
        'coefficient.required' => 'Коэффициент обязателен для заполнения',
    ];

    protected $appends = [
        'preview_image'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'box_name' => BoxName::class
    ];
    public $attachOne = [
        'image' => File::class
    ];

    public function getPreviewImageAttribute()
    {
        if (!empty($this->image)) {
            return $this->image->getThumb('264', '187', ['mode' => 'auto']);
        }

        return null;
    }
}

<?php namespace BizMark\Flexicon\Models;

use Model;
use System\Models\File;

/**
 * BoxName Model
 * @package BizMark\Flexicon\Models;
 * @author Nick Khaetsky @ Biz-Mark, nick@biz-mark.ru, info@biz-mark.ru
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                            $id
 * @property boolean                                        $name
 * @property \October\Rain\Argon\Argon                      $created_at
 * @property \October\Rain\Argon\Argon                      $updated_at
 *
 * Relations
 * @property BoxType[]                                      $box_types
 * @method \October\Rain\Database\Relations\HasMany|BoxType box_types()
 *
 * @property File                                           $image
 * @method \October\Rain\Database\Relations\AttachOne|File  image()
 */
class BoxName extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bizmark_flexicon_box_names';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required'
    ];

    public $customMessages = [
        'name.required' => 'Название обязательно для заполнения',
    ];

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

    protected $appends = [
        'preview_image'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'box_types' => [
            BoxType::class,
            'key' => 'box_name_id'
        ]
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

<?php namespace BizMark\Flexicon\Models;

use Model;
use System\Models\File;

/**
 * PaperType Model
 * @package BizMark\Flexicon\Models;
 * @author Nick Khaetsky @ Biz-Mark, nick@biz-mark.ru, info@biz-mark.ru
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                                $id
 * @property boolean                                            $name
 * @property string                                             $code
 * @property float                                               $price
 * @property string                                             $color
 * @property \October\Rain\Argon\Argon                          $created_at
 * @property \October\Rain\Argon\Argon                          $updated_at
 *
 * Relations
 * @property int                                                $paper_name_id
 * @property PaperName                                          $paper_name
 * @method \October\Rain\Database\Relations\BelongsTo|PaperName paper_name()
 *
 * @property File                                               $image
 * @method \October\Rain\Database\Relations\AttachOne|File      image()
 */
class PaperType extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bizmark_flexicon_paper_types';

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

    protected $appends = [
        'preview_image'
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'paper_name' => 'required',
        'code' => 'required',
        'price' => 'required',
    ];

    public $customMessages = [
        'paper_name.required' => '???????????????? ?????????????????????? ?????? ????????????????????',
        'code.required' => '?????????????? ?????????????? ???????????????????? ?????? ????????????????????',
        'price.required' => '?????????????????? ?????????????????????? ?????? ????????????????????',
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'paper_name' => PaperName::class
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

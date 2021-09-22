<?php namespace BizMark\Flexicon\Models;

use Model;
use System\Models\File;

/**
 * Order Model
 * @package BizMark\Flexicon\Models;
 * @author Nick Khaetsky @ Biz-Mark, nick@biz-mark.ru, info@biz-mark.ru
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int                                            $id
 * @property int                                            $number
 * @property string                                         $type
 * @property string                                         $organization
 * @property string                                         $full_name
 * @property string                                         $email
 * @property string                                         $phone
 * @property string                                         $comment
 * @property array                                          $cart
 * @property boolean                                        $is_read
 * @property float                                           $total_price
 * @property \October\Rain\Argon\Argon                      $created_at
 * @property \October\Rain\Argon\Argon                      $updated_at
 *
 * Relation
 * @property File[]                                         $requisites
 * @method \October\Rain\Database\Relations\AttachMany|File requisites()
 *
 * @property File[]                                         $designs
 * @method \October\Rain\Database\Relations\AttachMany|File designs()
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bizmark_flexicon_orders';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'type',
        'organization',
        'full_name',
        'email',
        'phone',
        'comment',
        'cart',
        'total_price',
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'organization' => 'required',
        'full_name' => 'required',
        'email' => 'required',
        'phone' => 'required'
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'cart'
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'requisites' => 'System\Models\File',
        'designs' => 'System\Models\File',
    ];

    public function afterSave()
    {
        if (empty($this->number)) {
            $this->number = $this->created_at->format('Y-m-d').'-'.$this->id;
            $this->save();
        }
    }

    public static function getUnreadCount()
    {
        return self::get()->where('is_read', false)->count();
    }
}

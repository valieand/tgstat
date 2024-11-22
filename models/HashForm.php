<?php

namespace app\models;

use yii\base\Model;

/**
 * HashForm is the model behind the link form.
 */
class HashForm extends Model
{
    /** @var string Cсылка */
    public $hash;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash'], 'required'],
            ['hash', 'match', 'pattern' => '/^[A-Za-z0-9_-]{5}$/i']
        ];
    }
}

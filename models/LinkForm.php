<?php

namespace app\models;

use yii\base\Model;

/**
 * LinkForm is the model behind the link form.
 */
class LinkForm extends Model
{
    /** @var string Cсылка */
    public $link;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'link' => 'Ссылка',
        ];
    }
}

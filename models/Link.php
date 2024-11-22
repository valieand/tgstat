<?php

namespace app\models;

/**
 * This is the model class for table "link".
 *
 * @property int $id ID
 * @property string $hash Хеш сокращенной ссылки
 * @property string $original Оригинальная ссылка
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash', 'original'], 'required'],
            [['original'], 'string'],
            ['hash', 'match', 'pattern' => '/^[A-Za-z0-9_-]{5}$/i'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Хеш сокращенной ссылки',
            'original' => 'Оригинальная ссылка',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $avatar
 * @property string $text
 * @property string $fio
 * @property integer $is_hide
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'fio'], 'required'],
            [['text'], 'string'],
            [['is_hide'], 'integer'],
            [['avatar'], 'string', 'max' => 50],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'avatar' => 'Аватар:',
            'text' => 'Комменратий *:',
            'fio' => 'ФИО *:',
            'is_hide' => 'Скрыт:',
        ];
    }
}

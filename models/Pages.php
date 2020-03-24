<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $h1
 * @property string $text
 * @property string $meta_keywords
 * @property string $meta_desc
 * @property string $ts
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'h1'], 'required'],
            [['text'], 'string'],
            [['ts'], 'safe'],
            [['slug', 'title', 'h1', 'meta_keywords', 'meta_desc'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'slug' => 'Slug *:',
            'title' => 'Заголовок страницы *:',
            'h1' => 'Заголвоок H1 *:',
            'text' => 'Контент:',
            'meta_keywords' => 'Ключевые слова (meta):',
            'meta_desc' => 'Описание (meta):',
            'ts' => '',
        ];
    }
}

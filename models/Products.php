<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property integer $price
 * @property string $desc_small
 * @property string $description
 * @property integer $is_sale
 * @property integer $is_hide
 * @property string $title
 * @property string $meta_key
 * @property string $meta_desc
 * @property string $ts
 */
class Products extends \yii\db\ActiveRecord
{
	public $imageFiles = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
            [['slug', 'name', 'price', 'title'], 'required'],
            [['price', 'is_sale', 'is_hide'], 'integer'],
            [['desc_small', 'description'], 'string'],
            [['ts'], 'safe'],
            [['slug', 'name', 'title', 'meta_key', 'meta_desc'], 'string', 'max' => 255],
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
            'name' => 'Название *:',
            'price' => 'Цена *:',
            'desc_small' => 'Короткое описание:',
			'description' => 'Полное описание:',
            'is_sale' => 'Акция:',
			'is_hide' => 'Скрыт:',
            'title' => 'Заголовок страницы *:',
            'meta_key' => 'Ключевые слова (meta):',
            'meta_desc' => 'Описание (meta):',
            'ts' => '',
        ];
    }
}

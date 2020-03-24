<?php

namespace app\models;

use Yii;

use app\models\Products;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property string $city
 * @property string $delivery
 * @property string $address
 * @property string $payment
 * @property string $products
 * @property integer $total_sum
 * @property integer $delivery_sum
 * @property string $comment
 * @property integer $user_id
 * @property integer $is_paid
 * @property string $ts
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'tel', 'fio', 'city', 'delivery', 'address', 'payment', 'products'], 'required'],
            [['total_sum', 'delivery_sum', 'user_id', 'is_paid'], 'integer'],
            [['ts'], 'safe'],
            [['tel'], 'string', 'max' => 20],
            [['fio', 'city', 'delivery', 'payment'], 'string', 'max' => 50],
            [['address', 'email'], 'string', 'max' => 100],
            [['products', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
			'email' => 'Е-мэйл',
            'tel' => 'Номер телефона',
            'fio' => 'ФИО',
            'city' => 'Город',
            'delivery' => 'Доставка',
            'address' => 'Адрес',
            'payment' => 'Метод оплаты',
            'products' => 'Продукты',
            'total_sum' => 'Общая сумма',
            'delivery_sum' => 'Цена доставки',
            'comment' => 'Комментарция',
            'user_id' => 'Id пользователя',
			'is_paid' => 'Оплачено',
            'ts' => 'Время заказа',
        ];
    }
}

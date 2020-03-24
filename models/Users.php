<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $pass
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $passport
 * @property string $tel
 * @property string $email_secret_key
 * @property string $recover_secret
 * @property string $ts
 */
class Users extends \yii\db\ActiveRecord
{
	public $total_friends = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'pass', 'firstname', 'lastname', 'middlename', 'passport', 'tel'], 'required'],
            [['ts'], 'safe'],
            [['email'], 'string', 'max' => 100],
            [['pass'], 'string', 'max' => 60],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 50],
            [['passport', 'tel', 'avatar'], 'string', 'max' => 20],
            [['email_secret_key', 'recover_secret'], 'string', 'max' => 32],
			[['referer', 'akciya_is_started', 'akciya_time_end', 'is_showed_popup_on_give_gift'], 'integer'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Iв',
            'email' => 'Е-мэйл',
            'pass' => 'Пароль',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'passport' => 'Серия и номер паспорта',
            'tel' => 'Номер телефона',
			'avatar' => 'Аватар',
            'email_secret_key' => '',
			'recover_secret' => '',
			'referer' => 0,
			'akciya_is_started' => 0,
			'akciya_time_end' => 0,
			'is_showed_popup_on_give_gift' => 0,
            'ts' => '',
        ];
    }
	
	public static function getFriendsAll($user_id)
	{
		$aFriends = self::find()->where(['referer' => $user_id])
							   ->orderBy('akciya_is_started DESC, ts DESC')->all();
		
		foreach($aFriends as $friend){
			$avatar_name = 'user_'.$friend->id.'.jpg';
			
			if(is_file(Yii::$app->params['dirUploads'].'/'.$avatar_name)){
				$friend->avatar = $avatar_name;
			}
			
			$friend->total_friends = self::find()->where(['referer' => $friend->id])->count();
		}
		
		return $aFriends;
	}
	public static function getFriendsWhoHasInAckiya($user_id)
	{
		$aFriends = self::find()->where(['referer' => $user_id, 'akciya_is_started' => 1])->all();
		
		foreach($aFriends as $friend){
			$avatar_name = 'user_'.$friend->id.'.jpg';
			
			if(is_file(Yii::$app->params['dirUploads'].'/'.$avatar_name)){
				$friend->avatar = $avatar_name;
			}
			
			$friend->total_friends = self::find()->where(['referer' => $friend->id])->count();
		}
		
		return $aFriends;
	}
	public static function showPopupForGiveGift($user_id)
	{
		$total_friends = sizeof(self::getFriendsWhoHasInAckiya($user_id));
		
		if($total_friends < 10){
			return false;
		}
		
		$user = self::findOne($user_id);
		
		// надо проверить на время
		if($user->akciya_time_end - time() <= 0){
			return false;
		}
		
		// проверим: показывали уже поп-ап, если нет, покажем и пометим
		if(!empty($user->is_showed_popup_on_give_gift)){
			return false;
		}
		
		$user->is_showed_popup_on_give_gift = 1;
		$user->save();

		return true;
	}
	public static function isAlreadySentRequestToTheReceiptOfGift($user_id)
	{
		return (new \yii\db\Query())->from('who_received_gifts')
									->where(['user_id' => $user_id])
									->limit(1)	
									->count();
	}
}

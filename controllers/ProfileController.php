<?php

namespace app\controllers;

use Yii;

use app\models\Images;
use app\models\Products;
use app\models\Orders;
use app\models\Users;

use yii\helpers\Html;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProfileController extends \yii\web\Controller
{
	public function beforeAction($action)
	{
		$session = Yii::$app->session;
		
		if(!$session->has('user')){
			return $this->goHome();
		}
		
		return parent::beforeAction($action);
	}
	private function getTimeOnTablo()
	{
		$result = ['days' => 0, 'hours' => 0, 'mins' => 0];
		$session = Yii::$app->session;
		
		if(empty($session['user']->akciya_time_end)){
			return $result;
		}
		
		$raznost = $session['user']->akciya_time_end - time();
		if($raznost <= 0){
			return $result;
		}
		
		$days = strval(floor($raznost / 86400));
		$hours = floor(($raznost - $days * 86400) / 3600);
		$mins = floor(($raznost - $days * 86400 - $hours * 3600) / 60);
		$aDays = array_map('intval', str_split($days));
		$aHours = array_map('intval', str_split($hours));
		$aMins = array_map('intval', str_split($mins));

		if(sizeof($aHours) === 1){
			$aHours = [0, $aHours[0]];
		}
		if(sizeof($aMins) === 1){
			$aMins = [0, $aMins[0]];
		}

		$result = [ 'days' => $aDays, 'hours' => $aHours, 'mins' => $aMins];
			
		return $result;
	}
	
    public function actionIndex()
    {
		return $this->redirect('/profile/friends');
    }
	public function actionFriends()
    {
		$session = Yii::$app->session;
		
		return $this->render('friends', [
			'aFriends' => Users::getFriendsAll($session['user']->id),
			'aTimeTablo' => $this->getTimeOnTablo(),
			'totalFriendsInAckiya' => sizeof(Users::getFriendsWhoHasInAckiya($session['user']->id)),
		]);
    }
    public function actionPurchases()
    {	
		$session = Yii::$app->session;
		
		// подтянем товары
			$rows = Orders::find()->where(['user_id' => $session['user']->id, 'is_paid' => 1])->all();
			$aIds = [];

			foreach($rows as $val){
				foreach(explode("|", $val->products) as $val2){
					list($products_id, $amount) = explode(":", $val2);
					$aIds[] = $products_id;
				}
			}

			$aIds = array_unique($aIds);

			$products = Products::find()->where(['id' => $aIds])->all();
				// подтянем картинки
				foreach($products as $product){
					$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
														->orderBy('pos DESC')
														->all();
				}
		// \подтянем товары
			
		return $this->render('purchases', [
			'products' => $products,
			'aTimeTablo' => $this->getTimeOnTablo(),
			'totalFriendsInAckiya' => sizeof(Users::getFriendsWhoHasInAckiya($session['user']->id))
		]);
    }
	public function actionSetAvatar()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$file	 = !empty($_FILES['avatar'])? $_FILES['avatar']: null;
		$dir_images = Yii::$app->params['dirUploads'];
				
		if($request->isPost){
			if(!empty($file)){
				if(empty($file['error'])){
					if(!empty($file['tmp_name'])){
						$file_name = 'user_'.$session['user']->id.'.jpg';
						
						$result = Image::thumbnail($file['tmp_name'], 300, 300)
									->save(Yii::getAlias($dir_images.'/'.$file_name), ['quality' => 90]);
						
						if($result){
							$session['user']->avatar = $file_name;
						}
					}
				}
			}
		}
		
		$go_back = $request->post('page');
		
		return !empty($go_back)? $this->redirect($go_back): $this->goHome();
	}
	public function actionCreateOrderOnGetGift()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$mailer = Yii::$app->mailer;
		
		$result = false;
		$msg = "";
		$aErrors = [];
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			//1. проверить кол-во друзей, учавствующих в акции на данный момент
				$totalFriends = sizeof(Users::getFriendsWhoHasInAckiya($session['user']->id));
				if($totalFriends < 10){
					$aErrors[] = "кол-во друзей, учавствующих в акции, в Вас менее 10";
				}

			//2. проверить: не отправлена ли уже заявка на получение приза
				$is_exists_zayavka = Users::isAlreadySentRequestToTheReceiptOfGift($session['user']->id);
				if($is_exists_zayavka){
					$aErrors[] = "заявка уже отправлена, ожидайте ответа от менеджера";
				}

			//3. не истекло ли время, выданное ему ранее
				if($session['user']->akciya_is_started && 
				  $session['user']->akciya_time_end && 
				  ($session['user']->akciya_time_end - time() <= 0)){
					$aErrors[] = "время акции истекло";
				}
			
			if(sizeof($aErrors) === 0){
				$city = $request->post('city');
				$delivery = $request->post('delivery');
				$address = $request->post('address');
				$comment = $request->post('comment', "");
				$dostavit_s_hour = $request->post('dostavit_s_hour', "");
				$dostavit_s_min = $request->post('dostavit_s_min', "");
				$dostavit_do_hour = $request->post('dostavit_do_hour', "");
				$dostavit_do_min = $request->post('dostavit_do_min', "");
				$data_dostavki = $request->post('data_dostavki', "");
				
				if(empty($city)){
					$aErrors[] = "укажите город";
				}
				if(empty($delivery)){
					$aErrors[] = "укажите способ доставки";
				}
				if(empty($address)){
					$aErrors[] = "укажите адрес";
				}
				
				if(sizeof($aErrors) === 0){
					$tmp_msg = implode(PHP_EOL, [
						'Город: '.Html::encode($city),
						'Доставка: '.Html::encode($delivery),
						'Адрес: '.Html::encode($address),
						'Дата доставки: '.Html::encode($data_dostavki).', '.
							Html::encode($dostavit_s_hour).':'.Html::encode($dostavit_s_min).' - '.
							Html::encode($dostavit_do_hour).':'.Html::encode($dostavit_do_min),
						'Комментарий: '.Html::encode($comment)
					]);
					
					Yii::$app->db->createCommand()->insert('who_received_gifts', [
						'user_id' => $session['user']->id,
						'comment' => $tmp_msg
					])->execute();
					
					$mailer->compose()
						->setFrom(Yii::$app->params['emailFrom'])
						->setTo(Yii::$app->params['emailWorker'])
						//->setTo(Yii::$app->params['emailDeveloper'])
						->setSubject('Запрос на получение подарка')
						->setTextBody($tmp_msg)
						->send();
					
					//$User = Users::findOne($session['user']->id);
					//$User->akciya_time_end = $session['user']->akciya_time_end = 0;
					//$User->save();
							
					$msg = 'Заявка о получении подарка создана. Ожидайте, с Вами свяжется менеджер.';
					$result = true;
					
				} else {
					$msg = implode('|', $aErrors);
				}
				
			} else {
				$msg = implode('|', $aErrors);
			}
			
		} else {
			$msg = 'не верный запрос';
		}
			
		Yii::$app->response->format = Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];	
	}
}
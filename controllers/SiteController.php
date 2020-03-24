<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\Products;
use app\models\Users;
use app\models\Images;
use app\models\Orders;
use app\models\Comments;
use app\models\Pages;
use app\models\Settings;

use yii\helpers\Html;
use yii\helpers\MyCustom;

use DateTime;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	public function beforeAction($action)
	{
		// ЯД-касса посылает сюда запросы, так что выключим тут проверку сертификата
		if($action->id == 'pay-check' || $action->id == 'pay-aviso'){
			//$this->loadCsrfToken();
			$this->enableCsrfValidation = false;
		}
		
		return parent::beforeAction($action);
	}
	
	private function countSumAllProductsInCart()
	{
		$sum = 0;
		$session = Yii::$app->session;
		
		if($session->has('cart')){
			$aProductIds = [];
			
			foreach($session['cart'] as $key => $val){
				$aProductIds[] = $key;
			}
			
			$data = Products::find()->select(['id', 'price'])->where(['id' => $aProductIds])->all();
			
			foreach($data as $obj){
				$sum += (int)$obj->price * $session['cart'][$obj->id];
			}
		}
		
		return $sum;
	}
	
    public function actionIndex()
    {
		$settings = Settings::find()->all();
		
		//1. товары по акции
		$products_sale = Products::find()->where(['is_sale' => 1, 'is_hide'=>0])
										->orderBy('id DESC')
										->all();
			// подтянем картинки
			foreach($products_sale as $product){
				$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
													->orderBy('pos DESC')
													->all();
			}
		
		//2. товара
		$products = Products::find()->where(['is_sale' => 0, 'is_hide'=>0])
									->orderBy('id DESC')
									->limit(3)
									->all();
			// подтянем картинки
			foreach($products as $product){
				$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
													->orderBy('pos DESC')
													->all();
			}
		//3. кол-во участников (всех)
			$total_participants = Users::find()->where(['akciya_is_started' => 1])->count() + $settings[0]->value;
		
		//4. кол-во выданых подарков
			$total_sent_gifts = (new \yii\db\Query())->from('who_received_gifts')->count() + $settings[1]->value;	
			
		return $this->render('index', [
			'products_sale'		=> $products_sale,
			'products'			=> $products,
			'comments'			=> Comments::find()->where(['is_hide' => 0])->orderBy('id DESC')->all(),
			'total_participants' => $total_participants,
			'total_sent_gifts'	=> $total_sent_gifts
		]);
    }
	public function actionCart()
	{
		$products = [];
		$session = Yii::$app->session;
		$show_btn_with_sale = false;
		
		if($session->has('cart')){
			foreach($session['cart'] as $key => $val){
				$objProduct = Products::findOne($key);
				$objProduct->imageFiles = Images::find()->where(['product_id' => $objProduct->id])
														->orderBy('pos DESC')
														->all();
				$products[] = ['data' => $objProduct, 'total' => $val];
				
				if(!$show_btn_with_sale && !empty($objProduct->is_sale) && 
				   $session->has('user') && empty($session['user']->akciya_is_started)){
					$show_btn_with_sale = true;
				}
			}
		}
		
		return $this->render('cart', [
			'products' => $products,
			'total_sum' => $this->countSumAllProductsInCart(),
			'show_btn_with_sale' => $show_btn_with_sale
		]);
	}
	public function actionCatalog()
	{
		//1. товары по акции
		$products_sale = Products::find()->where(['is_sale' => 1, 'is_hide'=>0])
										->orderBy('id DESC')
										->all();
			// подтянем картинки
			foreach($products_sale as $product){
				$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
													->orderBy('pos DESC')
													->all();
			}
		
		//2. товара
		$products = Products::find()->where(['is_sale' => 0, 'is_hide'=>0])
									->orderBy('id DESC')
									->all();
			// подтянем картинки
			foreach($products as $product){
				$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
													->orderBy('pos DESC')
													->all();
			}
		
		return $this->render('catalog', [
			'products_sale' => $products_sale,
			'products'		=> $products,
		]);
	}
	public function actionHelp()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$mailer = Yii::$app->mailer;
		
		if($request->isPost){
			$fio = $request->post('fio');
			$private_number = $request->post('private_number');
			$email = $request->post('email');
			$tel = $request->post('tel');
			$message = $request->post('message');
			
			if(empty($fio)){
				$session->addFlash('error', 'впишите ФИО');
			}
			if(empty($private_number)){
				$session->addFlash('error', 'впишите личный номер');
			}
			if(empty($tel)){
				$session->addFlash('error', 'впишите номер телефона');
			}
			if(empty($message)){
				$session->addFlash('error', 'впишите сообщение');
			}
			if(empty($email)){
				$session->addFlash('error', 'впишите е-мэйл');
			
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$session->addFlash('error', 'укажите корректный е-мэйл');
			}
			
			if(!$session->hasFlash('error')){
				$aData = [
					'fio' => $fio,
					'email' => $email,
					'private_number' => $private_number,
					'tel' => $tel,
					'msg' => $message,
				];
				// отправляем данные
				$sent = $mailer->compose('help', $aData)
								->setFrom(Yii::$app->params['emailFrom'])
								->setTo(Yii::$app->params['emailWorker'])
								->setSubject('Cообщение со страницы HELP')
								->send();
				
				if($sent){
					$session->addFlash('success');
					
					return $this->redirect('help');
				
				} else {
					$session->addFlash('error', 'внутренняя ошибка отправки сообщения');
				}
			}
			
			$session->addFlash('old', [
				'fio' => $fio,
				'privateNumber' => $private_number,
				'email' => $email,
				'tel' => $tel,
				'message' => $message
			]);
		}
		
		return $this->render('help');
	}
	public function actionProduct($slug)
	{
		$product = Products::findOne(['slug' => $slug, 'is_hide'=>0]);
		
		if(empty($product)){
			throw new NotFoundHttpException('Product not found.');
		}
		
		$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
											->orderBy('pos DESC')
											->all();
		
		$settings = Settings::find()->all();
		$total_participants = Users::find()->where(['akciya_is_started' => 1])->count() + $settings[0]->value;
		$total_sent_gifts = (new \yii\db\Query())->from('who_received_gifts')->count() + $settings[1]->value;
			
		return $this->render('tovar', [
			'product' => $product,
			'total_participants' => $total_participants,
			'total_sent_gifts'	=> $total_sent_gifts
		]);
	}
	public function actionLogin()
    {
		$result = false;
		$msg	= "";
		$aErrors = [];
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$email = $request->post('email');
			$pass = $request->post('pass');
			
			if(empty($email)){
				$aErrors[] = 'впишите е-мэйл';
			
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$aErrors[] = 'укажите корректный е-мэйл';
			}
			
			if(empty($pass)){
				$aErrors[] = 'впишите пароль';
			}
			
			if(sizeof($aErrors) === 0){
				$user = Users::findOne(['email' => $email]);
				
				if($user !== null){
					if($user->email_secret_key !== ""){
						$msg = 'активируйте свою почту, на нее было вылано письмо с cсылкой';

					} elseif (Yii::$app->getSecurity()->validatePassword($pass, $user->pass)) {
						$session['user'] = $user;
						$avatar_name = 'user_'.$session['user']->id.'.jpg';
						
						if(is_file(Yii::$app->params['dirUploads'].'/'.$avatar_name)){
							$session['user']->avatar = $avatar_name;
						}
						
						$result = true;
						
					} else {
						$msg = 'неверные данные логин/пароль';
					}
					
				} else {
					$msg = 'пользователя с такими данными нет';
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
	public function actionLogout()
    {
		$session = Yii::$app->session;
		
		if($session->has('user')){
			$session->remove('user');
		}

        return $this->goHome();
    }
	public function actionRegistration()
    {
		$result = false;
		$msg	= "";
		$aErrors = [];
		$request = Yii::$app->request;
		$mailer = Yii::$app->mailer;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$email = $request->post('email');
			$tel = $request->post('tel');
			$pass = $request->post('pass');
			$pass_c = $request->post('pass_c');
			$firstname = $request->post('firstname');
			$lastname = $request->post('lastname');
			$middlename = $request->post('middlename');
			$passport = $request->post('passport');
			$is_agree = $request->post('is_agree');
			$referer = !empty($request->post('referer'))? (int)$request->post('referer'): 0;
			$referer_url = $request->post('referer_url');
			
			// распотрашим ссылку реферера
			if(!empty($referer_url)){
				if(is_numeric($referer_url)){
					$referer = (int)$referer_url;
				
				} else {
					$tmp = parse_url($referer_url);
					if(!empty($tmp['query'])){
						$tmp2 = substr_count($tmp['query'], "&")? explode("&", $tmp['query']): [$tmp['query']];
						
						foreach($tmp2 as $val){
							list($key, $value) = explode("=", $val);
							if(!empty($key) && $key === 'referer' && !empty($value) && is_numeric($value)){
								$referer = (int)$value;
							}
						}
					}
				}
			}
			
			if(empty($email)){
				$aErrors[] = 'впишите е-мэйл';
			
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$aErrors[] = 'укажите корректный е-мэйл';
			}
			
			if(empty($tel)){
				$aErrors[] = 'впишите номер телефона';
			}
			if(empty($pass)){
				$aErrors[] = 'впишите пароль';
			}
			if(empty($pass_c)){
				$aErrors[] = 'впишите пароль (повтор)';
			}
			if(empty($firstname)){
				$aErrors[] = 'впишите имя';
			}
			if(empty($lastname)){
				$aErrors[] = 'впишите фамилию';
			}
			if(empty($middlename)){
				$aErrors[] = 'впишите отчество';
			}
			if(empty($passport)){
				$aErrors[] = 'впишите серию и номер паспорта';
			}
			if(empty($is_agree)){
				$aErrors[] = 'примите соглашение договора оферты';
			}
			
			if(sizeof($aErrors) === 0){
				if($pass === $pass_c){
					$user = Users::findOne(['email' => $email]);
					
					if($user !== null){
						if($user->email_secret_key !== ""){
							$msg = 'активируйте свою почту, на нее было выслано письмо с cсылкой';
							
						} else {
							$msg = 'войдите под своим аккаунтом';
						}
						
					} else {
						$secret = md5(uniqid(rand(),true));
						
						$user = null;
						$user = new Users();
							$user->email = $email;
							$user->tel = $tel;
							$user->pass = Yii::$app->getSecurity()->generatePasswordHash($pass);
							$user->firstname = $firstname;
							$user->lastname = $lastname;
							$user->middlename = $middlename;
							$user->passport = $passport;
							$user->email_secret_key = $secret;
							$user->referer = $referer;
						$user->save();
						
						if($user->id){
							// отправляем данные
							$aData = [
								'secret' => $secret,
								'email' => $email,
								'fio' => $firstname." ".$lastname." ".$middlename
							];
							
							$mailer->compose('reg', $aData)
									->setFrom(Yii::$app->params['emailFrom'])
									->setTo($email)
									->setSubject('Регистрация, подтверждение е-мэйла.')
									->send();
							
							$msg = 'Регистрация прошла успешно, но для окончательного подтверждения необходимо подтвердить свой е-мэйл адрес. На него ('.$email.') было выслано сообщение. Пройдите по ссылке в письме.';
							$result = true;
						
						} else {
							$msg = 'данные не записались';
						}
					}
					
				} else {
					$msg = 'пароли не совпадают';
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
	public function actionAddToCart()
	{
		$result = false;
		$msg	= "";
		
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$product_id = $request->post('id');
			
			if(!$session->has('cart')){
				$session['cart'] = new \ArrayObject;
			}
			
			// проверим на возможность добавления товара по акции без регистрации
			$Product = Products::findOne($product_id);
			
			if($Product->is_sale && !$session->has('user')){
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ['result' => $result, 'msg' => 'Необходима регистрация!'];
			}
			
			if(isset($session['cart'][$product_id])){
				$session['cart'][$product_id]++;
				
			} else {
				$session['cart'][$product_id] = 1;
			}
			
			$result = true;
		}
		
		Yii::$app->response->format = Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	public function actionRemoveFromCart()
	{
		$result = false;
		$msg	= "";
		
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$product_id = $request->post('id');
			
			if($session->has('cart')){
				if(isset($session['cart'][$product_id])){
					unset($session['cart'][$product_id]);
					
					$msg = MyCustom::htmlPrice($this->countSumAllProductsInCart());
					$result = true;
					
				} else {
					$msg = 'не найден товар в корзине';
				}
				
			} else {
				$msg = 'отсутствуют данные о товарах в корзине';
			}
		}
		
		Yii::$app->response->format = Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	public function actionUpdateAmountCart()
	{
		$result = false;
		$msg	= "";
		
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$product_id = $request->post('id');
			$amount = abs(intval($request->post('amount')));
			
			if($session->has('cart')){
				if(isset($session['cart'][$product_id])){
					if(!empty($amount)){
						$session['cart'][$product_id] = $amount;
						$tmp = Products::find()->select(['price'])
												->where(['id' => $product_id])
												->limit(1)
												->one();
						$price = intval($tmp->price);
						
						$msg = [
							'total_sum' => MyCustom::htmlPrice($this->countSumAllProductsInCart()),
							'total_cur' => MyCustom::htmlPrice($price * $amount),
						];
						$result = true;
						
					} else {
						$msg = 'не известно на сколько прибавлять';
					}
					
				} else {
					$msg = 'не найден товар в корзине';
				}
				
			} else {
				$msg = 'отсутствуют данные о товарах в корзине';
			}
		}
		
		Yii::$app->response->format = Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	public function actionAddOrder()
	{
		$result = false;
		$msg	= "";
		$aErrors = [];
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$mailer = Yii::$app->mailer;
		
		if($request->isAjax === false){
			throw new NotFoundHttpException('Page not found.');
		}
		
		if($request->isPost){
			$tel = $request->post('tel');
			$fio = $request->post('fio');
			$city = $request->post('city');
			$delivery = $request->post('delivery');
			$address = $request->post('address');
			$payment = $request->post('payment');
			$comment = $request->post('comment');
			$email = $session->has('user')? $session['user']->email: $request->post('email');
			
			if(empty($tel)){
				$aErrors[] = "впишите номер телефона";
			}
			if(empty($fio)){
				$aErrors[] = "впишите ФИО";
			}
			if(empty($city)){
				$aErrors[] = "выберите город";
			}
			if(empty($delivery)){
				$aErrors[] = "выберите способ доставки";
			}
			if(empty($address)){
				$aErrors[] = "укажите адрес";
			}
			if(empty($payment)){
				$aErrors[] = "выберите способ оплаты";
			}
			if(!$session->has('cart') || ($session->has('cart') && !sizeof($session['cart']))){
				$aErrors[] = "товаров нет в корзине";
			}
			if(empty($comment)){
				$comment = "";
			}
			if(empty($email)){
				$aErrors[] = "впишите е-мэйл";
			
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$aErrors[] = "впишите корректный е-мэйл";
			}
			
			if(sizeof($aErrors) === 0){
				$aProducts = [];
				foreach($session['cart'] as $product_id => $amount){
					$aProducts[] = $product_id.":".$amount;
				}
				$sProducts = implode("|", $aProducts);
				
				// добавим новую запись о заказе
				$Order = new Orders();
					$Order->email = $email;
					$Order->tel = $tel;
					$Order->fio = $fio;
					$Order->city = $city;
					$Order->delivery = $delivery;
					$Order->address = $address;
					$Order->payment = $payment;
					$Order->products = $sProducts;
					$Order->total_sum = $this->countSumAllProductsInCart();
					$Order->delivery_sum = 0;
					$Order->comment = $comment;
					$Order->user_id = $session->has('user')? $session['user']->id: 0;
				$Order->save();
				
				if($Order->id){
					// отправляем 2 письма (начальству и покупателю)
					$subject = 'Заказ №'.$Order->id;
					$messages = [];
					$aHtmlData = ['Order' => $Order];
					$messages[] = $mailer->compose('order', $aHtmlData)
										->setFrom(Yii::$app->params['emailFrom'])
										->setTo($email)
										->setSubject($subject);
					$messages[] = $mailer->compose('order', $aHtmlData)
										->setFrom(Yii::$app->params['emailFrom'])
										->setTo(Yii::$app->params['emailWorker'])
										->setSubject($subject);
					$is_send = $mailer->sendMultiple($messages);
					
					// очистим карзину
					unset($session['cart']);
					$session['cart'] = new \ArrayObject;
					
					// тут сформируем пересылку на платежную систему
					$form_id = 'form_'.time();
					
					// тут использовалось для ЯД-кассы
//					$ar = [
//						'<form id="'.$form_id.'" action="https://demomoney.yandex.ru/eshop.xml" method="POST" style="display:none">',
//							'<input name="shopId" value="'.Yii::$app->params['shopId'].'" type="hidden">',
//							'<input name="scid" value="'.Yii::$app->params['scid'].'" type="hidden">',
//							'<input name="customerNumber" value="'.$Order->email.'" type="hidden">',
//							'<input name="sum" value="'.$Order->total_sum.'" type="hidden">',
//							'<input name="orderNumber" value="'.$Order->id.'" type="hidden">',
//						'</form>',
//						'<script>$("#'.$form_id.'").submit();</script>'
//					];
					
					// РОБОКАССА
					// регистрационная информация (логин, пароль #1)
					$mrh_login = Yii::$app->params['robokassa_login'];
					$mrh_pass1 = Yii::$app->params['robokassa_pass1'];

					// номер заказа
					$inv_id = $Order->id;

					// описание заказа
					$inv_desc = "Оплата заказа #".$inv_id;

					// сумма заказа
					$out_summ = $Order->total_sum;

					// тип товара
					$shp_item = "2";

					// предлагаемая валюта платежа
					$in_curr = "";

					// язык
					$culture = "ru";
					
					// кодировка
					$encoding = "utf-8";
					
					// формирование подписи
					$crc  = hash('sha256', "$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
					
					// форма оплаты товара
					// payment form
					$ar = [
						"<form id='".$form_id."' action='https://merchant.roboxchange.com/Index.aspx' method=POST>",
							"<input type=hidden name=MrchLogin value=$mrh_login>",
							"<input type=hidden name=OutSum value=$out_summ>",
							"<input type=hidden name=InvId value=$inv_id>",
							"<input type=hidden name=Desc value='$inv_desc'>",
							"<input type=hidden name=SignatureValue value=$crc>",
							"<input type=hidden name=Shp_item value='$shp_item'>",
							"<input type=hidden name=IncCurrLabel value=$in_curr>",
							"<input type=hidden name=Culture value=$culture>",
							"<input type=hidden name=Encoding value=$encoding>",
							"<input type=submit value='Pay'>",
						"</form>",
						'<script>$("#'.$form_id.'").submit();</script>'
					];
					
					$msg = implode("", $ar);
					$result = true;
					
				} else {
					$msg = 'заказ не записался в базу данных';
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
	public function actionConfirmEmail()
	{
		$result = false;
		$request = Yii::$app->request;
		
		$secret = $request->get('secret');
		
		if(!empty($secret)){
			$User = Users::findOne(['email_secret_key' => $secret]);
			
			if(!empty($User)){
				$User->email_secret_key = "";
				$User->save();

				$result = true;
			}
		}
		
		return $this->render('confirm_email', [
            'result' => $result,
        ]);
	}
	public function actionRecoverPass()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		$mailer = Yii::$app->mailer;
		
		if($request->isPost){
			$email = $request->post('email');
			
			if(!empty($email)){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$User = Users::findOne(['email' => $email]);
				
					if(!empty($User)){
						if(empty($User->email_secret_key)){
							$secret = md5(uniqid(rand(),true));
							$res = $mailer->compose('recover_pass', ['secret' => $secret])
											->setFrom(Yii::$app->params['emailFrom'])
											->setTo($email)
											->setSubject('Восстановление пароля')
											->send();
							
							if($res){
								$User->recover_secret = $secret;
								$User->save();
								$session->addFlash('success');
								
								return $this->redirect('recover-pass');
							}
							
						} else {
							$session->addFlash('error', 'ваш е-мэйл еще не подтвержден');
						}

					} else {
						$session->addFlash('error', 'неизвестный почтовый адрес');
					}	
					
				} else {
					$session->addFlash('error', 'впишите корректный е-мэйл');
				}
				
			} else {
				$session->addFlash('error', 'впишите е-мэйл');
			}
		}
		
		return $this->render('recover_pass');
	}
	public function actionCreateNewPass()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isPost){
			$pass = $request->post('pass');
			$pass_c = $request->post('pass_c');
			$secret = $request->post('secret');
			
			if(empty($pass)){
				$session->addFlash('error', 'впишите пароль');
			}
			if(empty($pass_c)){
				$session->addFlash('error', 'впишите пароль (повтор)');
			}
			if(empty($secret)){
				$session->addFlash('error', 'не известен шифр');
			}
			
			if(!$session->hasFlash('error')){
				if($pass === $pass_c){
					$User = Users::findOne(['recover_secret' => $secret]);
					
					if(!empty($User)){
						$User->pass = Yii::$app->getSecurity()->generatePasswordHash($pass);
						$User->recover_secret = "";
						$User->save();
						
						$session->addFlash('success');
					
					} else {
						$session->addFlash('error', 'не найден пользователь, у которого нужно изменить пароль');
					}
					
				} else {
					$session->addFlash('error', 'пароли не совпадают');
				}
			}
			
		} elseif ($request->get('secret')) {
			$secret = $request->get('secret');
			
			$User = Users::findOne(['recover_secret' => $secret]);
			
			if(!empty($User)){
				return $this->goHome();
			}
			
		} else {
			return $this->goHome();
		}
		
		return $this->render('create_new_pass', [
			'secret' => $secret
		]);
	}
	public function actionPage($slug = '')
	{
		$Page = Pages::findOne(['slug' => $slug]);
		
		if(empty($Page)){
			throw new NotFoundHttpException('Page not found.');
		}
		
		return $this->render('page', [
			'Page' => $Page
		]);
	}
	
	// ответы от платежной системы
	public function actionPaySuccess()
	{
		$request = Yii::$app->request;
		$dop = "";
		
		if($request->isPost){
			$inv_id = $request->post("InvId");
			
			if($inv_id){
				$dop = "(заказ #$inv_id)";
			}
		}
		
		echo "Операция $dop прошла успешно.\n";
	}
	public function actionPayFail()
	{
		$request = Yii::$app->request;
		$dop = "";
		
		if($request->isPost){
			$inv_id = $request->post("InvId");
			
			if($inv_id){
				$dop = "Заказ #$inv_id\n";
			}
		}
		
		echo "Вы отказались от оплаты. ".$dop;
	}
	public function actionPayResult()
	{
		$request = Yii::$app->request;
		$mailer = Yii::$app->mailer;
		
		if($request->isPost){
			// регистрационная информация (пароль #2)
			$mrh_pass2 = Yii::$app->params['robokassa_pass2'];
			
			//установка текущего времени
			$tm = getdate(time()+9*3600);
			$date = "$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";
			
			// чтение параметров
			$out_summ = $request->post("OutSum");
			$inv_id = $request->post("InvId");
			$crc = strtoupper($request->post("SignatureValue"));
			$my_crc = strtoupper(hash('sha256', "$out_summ:$inv_id:$mrh_pass2"));
			
			// проверка корректности подписи
			if ($my_crc !== $crc){
				exit("bad sign\n");
			}
			
			$order = Orders::findOne($inv_id);
			
			if(empty($order)){
				mail(Yii::$app->params['emailDeveloper'], 'ifomania.ru - cтранная ошибка после оплаты', 'Подтверждение оплаты пользователем, но почему-то такого заказа нет - '.$inv_id);
				exit;
			}
			
			// делаем метку что заказ оплатили
			$order->is_paid  = 1;
			$order->save();

			// отправляем 2 письма (начальству и покупателю)
			$subject = 'Заказ №'.$order->id;
			$messages = [];
			$aHtmlData = ['Order' => $order];
			$messages[] = $mailer->compose('order', $aHtmlData)
								->setFrom(Yii::$app->params['emailFrom'])
								->setTo($order->email)
								->setSubject($subject);
			$messages[] = $mailer->compose('order', $aHtmlData)
								->setFrom(Yii::$app->params['emailFrom'])
								->setTo(Yii::$app->params['emailWorker'])
								->setSubject($subject);
			$is_send = $mailer->sendMultiple($messages);

			// тут надо проверить, присудствует ли среди продуктов товар по акции, если да, то пользователь участвует в акции, при наличии если он зарегистрирован
			if(!empty($order->user_id)){
				// надо проверить, учавствует ли пользователь уже в акции
				$User = Users::findOne($order->user_id);
				// если нет, то идем дальше
				if(empty($User->akciya_is_started)){
					$products = [];
					foreach(explode('|', $order->products) as $val){
						list($product_id, $amount) = explode(":", $val);

						$objProduct = Products::findOne((int)$product_id);

						// если этот продукт по акции, то делаем метку пользователю о старте акции
						if(!empty($objProduct) && !empty($objProduct->is_sale)){
							$User->akciya_is_started = 1;
							$User->akciya_time_end = mktime(0, 0, 0, 9, 1, 2017);//strtotime("+1 month");
							$User->save();

							break;
						}
					}
				}			
			}
			
			echo "OK$inv_id\n";
			
		} else {
			throw new NotFoundHttpException;
		}
	}
	
	// for Yandex-kassa
	public function actionPayCheck()
	{
		$request = Yii::$app->request;
		// коды ответа
			// 0 - такой товар есть в магазине
			// 1 - полученная MD5-сумма не совпадает с MD5-суммой на стороне магазина
			// 100 - такого заказа нет в магазине
			// 200 - не удается выполнить разбор полученных параметров
		if($request->isSecureConnection && $request->isPost){
			// проверка наличия заказа
			$date = new DateTime();
			$invoiceId = 0;
			$time = $date->format("Y-m-d") . "T" . $date->format("H:i:s") . ".000" . $date->format("P");
			
			$p['action'] = $request->post('action');
			$p['orderSumAmount'] = $request->post('orderSumAmount');
			$p['orderSumCurrencyPaycash'] = $request->post('orderSumCurrencyPaycash');
			$p['orderSumBankPaycash'] = $request->post('orderSumBankPaycash');
			$p['shopId'] = $request->post('shopId');
			$p['invoiceId'] = $request->post('invoiceId');
			$p['customerNumber'] = $request->post('customerNumber');
			$p['orderNumber'] = $request->post('orderNumber');
			$p['md5'] = $request->post('md5');
			
			if(
				!empty($p['action']) && 
				!empty($p['orderSumAmount']) && 
				!empty($p['orderSumCurrencyPaycash']) && 
				!empty($p['orderSumBankPaycash']) && 
				!empty($p['shopId']) && 
				!empty($p['invoiceId']) && 
				!empty($p['customerNumber']) && 
				!empty($p['orderNumber']) && 
				!empty($p['md5'])
				){
				$invoiceId = $p['invoiceId'];
				
				// взять сумму заказа из базы
				$order = Orders::findOne($p['orderNumber']);
				
				if(!empty($order)){
					// искуственно добавим ".00"
					$str = $p['action'].";".
						$order->total_sum.".00;".$p['orderSumCurrencyPaycash'].";".
						$p['orderSumBankPaycash'].";".$p['shopId'].";".
						$p['invoiceId'].";".$p['customerNumber'].";".Yii::$app->params['shop_pasword'];
					$md5 = strtoupper(md5($str));
				
					// если все нормально
					if($md5 === strtoupper($p['md5'])){
						$order->invoiceId = $p['invoiceId'];
						$order->save();
						
						$code = 0;

					} else {
						$code = 1;
					}
					
				} else {
					$code = 100;
				}
				
			} else {
				$code = 200;
			}
			
			Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
			Yii::$app->response->statusCode = 200;
			
			exit('<?xml version="1.0" encoding="UTF-8"?><checkOrderResponse performedDatetime="'.$time.'" code="'.$code.'" invoiceId="'.$invoiceId.'" shopId="'.Yii::$app->params['shopId'].'"/>');
			
		} else {
			throw new NotFoundHttpException;
		}
	}
	// for Yandex-kassa
	public function actionPayAviso()
	{
		$request = Yii::$app->request;
		$mailer = Yii::$app->mailer;
		// коды ответа
			// 0 - такой товар есть в магазине
			// 1 - полученная MD5-сумма не совпадает с MD5-суммой на стороне магазина
			// 200 - не удается выполнить разбор полученных параметров
		if($request->isSecureConnection && $request->isPost){
			// проверка наличия заказа
			$date = new DateTime();
			$invoiceId = 0;
			$time = $date->format("Y-m-d") . "T" . $date->format("H:i:s") . ".000" . $date->format("P");
			
			$p['action'] = $request->post('action');
			$p['orderSumAmount'] = $request->post('orderSumAmount');
			$p['orderSumCurrencyPaycash'] = $request->post('orderSumCurrencyPaycash');
			$p['orderSumBankPaycash'] = $request->post('orderSumBankPaycash');
			$p['shopId'] = $request->post('shopId');
			$p['invoiceId'] = $request->post('invoiceId');
			$p['customerNumber'] = $request->post('customerNumber');
			$p['orderNumber'] = $request->post('orderNumber');
			$p['md5'] = $request->post('md5');
			
			if(
				!empty($p['action']) && 
				!empty($p['orderSumAmount']) && 
				!empty($p['orderSumCurrencyPaycash']) && 
				!empty($p['orderSumBankPaycash']) && 
				!empty($p['shopId']) && 
				!empty($p['invoiceId']) && 
				!empty($p['customerNumber']) && 
				!empty($p['orderNumber']) && 
				!empty($p['md5'])
				){
				$invoiceId = $p['invoiceId'];
				
				// взять сумму заказа из базы
				$order = Orders::findOne($p['orderNumber']);
				
				if(empty($order)){
					mail(Yii::$app->params['emailDeveloper'], 'ifomania.ru - cтранная ошибка после оплаты', 'Подтверждение оплаты пользователем, но почему-то такого заказа нет - '.$p['orderNumber']);
					exit;
				}
				
				// искуственно добавим ".00"
				$str = $p['action'].";".
					$order->total_sum.".00;".$p['orderSumCurrencyPaycash'].";".
					$p['orderSumBankPaycash'].";".$p['shopId'].";".
					$p['invoiceId'].";".$p['customerNumber'].";".Yii::$app->params['shop_pasword'];
				$md5 = strtoupper(md5($str));

				// если все нормально
				if($md5 === strtoupper($p['md5'])){
					// делаем метку что заказ оплатили
					$order->is_paid  = 1;
					$order->save();
					
					// отправляем 2 письма (начальству и покупателю)
					$subject = 'Заказ №'.$order->id;
					$messages = [];
					$aHtmlData = ['Order' => $order];
					$messages[] = $mailer->compose('order', $aHtmlData)
										->setFrom(Yii::$app->params['emailFrom'])
										->setTo($order->email)
										->setSubject($subject);
					$messages[] = $mailer->compose('order', $aHtmlData)
										->setFrom(Yii::$app->params['emailFrom'])
										->setTo(Yii::$app->params['emailWorker'])
										->setSubject($subject);
					$is_send = $mailer->sendMultiple($messages);
					
					// тут надо проверить, присудствует ли среди продуктов товар по акции, если да, то пользователь участвует в акции, при наличии если он зарегистрирован
					if(!empty($order->user_id)){
						// надо проверить, учавствует ли пользователь уже в акции
						$User = Users::findOne($order->user_id);
						// если нет, то идем дальше
						if(empty($User->akciya_is_started)){
							$products = [];
							foreach(explode('|', $order->products) as $val){
								list($product_id, $amount) = explode(":", $val);

								$objProduct = Products::findOne((int)$product_id);
								
								// если этот продукт по акции, то делаем метку пользователю о старте акции
								if(!empty($objProduct) && !empty($objProduct->is_sale)){
									$User->akciya_is_started = 1;
									$User->akciya_time_end = mktime(0, 0, 0, 9, 1, 2017);//strtotime("+1 month");
									$User->save();
									
									break;
								}
							}
						}			
					}
			
					$code = 0;

				} else {
					$code = 1;
				}	
				
			} else {
				$code = 200;
			}
			
			Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
			Yii::$app->response->statusCode = 200;
			
			exit('<?xml version="1.0" encoding="UTF-8"?><paymentAvisoResponse performedDatetime="'.$time.'" code="'.$code.'" invoiceId="'.$invoiceId.'" shopId="'.Yii::$app->params['shopId'].'"/>');
			
		} else {
			throw new NotFoundHttpException;
		}
	}
}

<?php

namespace app\controllers;

use Yii;

use yii\web\UploadedFile;

use app\models\Users;
use app\models\Orders;
use app\models\Products;
use app\models\Comments;
use app\models\Pages;
use app\models\Images;
use app\models\Settings;

use yii\helpers\MyCustom;

use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class AdminController extends \yii\web\Controller
{
	public $layout = 'admin';
    
	public function beforeAction($action)
	{
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		
		if($session->has('admin')){
			if($action->id === 'login'){
				return $this->redirect('/admin/products');
			}
			
			$this->enableCsrfValidation = false;
			
		} else {
			if($request->isPost){
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return ['result' => false, 'msg' => 'нужны права админа'];
			}
			
			if($action->id !== 'login'){
				return $this->redirect('/admin/login');
			}
		}
		
		return parent::beforeAction($action);
	}
	public function actionIndex()
    {
		return $this->redirect('/admin/products');
    }
	public function actionUsers()
	{
		$users = Users::find()->orderBy('ts DESC')->all();
		
		foreach($users as $user){
			if(is_file(Yii::$app->params['dirUploads'].'/user_'.$user->id.'.jpg')){
				$user->avatar = 'user_'.$user->id.'.jpg';
			}
		}
		
		return $this->render('users', [
			'users' => $users
		]);
	}
	public function actionUserUpdate($id)
	{
		$user = Users::findOne($id);
		$aDataOnGiveGift = (new \yii\db\Query())->from('who_received_gifts')
												 ->where(['user_id' => $user->id])
												 ->one();
		$aOrders = Orders::find()->where(['user_id' => $user->id])
								 ->orderBy('ts ASC')
								 ->all();
		
		return $this->render('user_update', [
			'model' => $user,
			'aOrders' => $aOrders,
			'aDataOnGiveGift' => $aDataOnGiveGift
		]);
	}
	public function actionOrders()
	{	
		$orders = Orders::find()->orderBy('ts DESC')->all();
		
		return $this->render('orders', [
			'orders' => $orders
		]);
	}
	public function actionGetOrder($id)
	{
		$Order = Orders::findOne($id);
		
		$aProducts = [];
		foreach(explode("|", $Order->products) as $val){
			list($product_id, $amount) = explode(":", $val);
			
			$product = Products::findOne($product_id);
			$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
												->orderBy('pos DESC')
												->all();
			
			$aProducts[] = ['product'=>$product, 'amount' => $amount];
		}
		
		return $this->render('order', [
			'Order' => $Order,
			'aProducts' => $aProducts,
		]);
	}
	public function actionLogin()
	{
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isPost){
			$login = $request->post('login');
			$pass = $request->post('pass');
			
			if(empty($login)){
				$session->addFlash('error', 'впишите логин');
			}
			if(empty($pass)){
				$session->addFlash('error', 'впишите пароль');
			}
			
			if(!$session->hasFlash('error')){
				if($login === Yii::$app->params['adminLogin'] && $pass === Yii::$app->params['adminPass']){
					$session['admin'] = 1;
					
					return $this->redirect('/admin');
					
				} else {
					$session->addFlash('error', 'неверная пара логин/пароль');
				}
			}
		}
		
		return $this->render('login');
	}
	public function actionLogout()
	{
		$session = Yii::$app->session;
		
		if($session->has('admin')){
			$session->remove('admin');
		}

        return $this->redirect('/admin');
	}
	public function actionUploadImage()
	{
		$request = Yii::$app->request;
		
		if(!$request->isPost || empty($_FILES['upload'])){
			exit;
		}
		
		$msg = "";
		$output_file_path = "";
		$orig_name = $_FILES['upload']['name'];
		$callback = $request->get('CKEditorFuncNum');
		$ext = pathinfo($orig_name, PATHINFO_EXTENSION);
		$hash = sha1_file($_FILES['upload']['tmp_name']).".".$ext;
		$dir_images = Yii::$app->params['dirUploads'];
		
		Image::getImagine()->open($_FILES['upload']['tmp_name'])
							->thumbnail(new Box(600, 600))
							->save($dir_images.'/'.$hash, ['quality' => 100]);
		$output_file_path = '/uploads/'.$hash;
		
		exit('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'","'.$output_file_path.'","'.$msg.'" );</script>');
	}
	
	public function actionProducts()
	{
		$products = Products::find()->orderBy('id DESC')->all();
		
		foreach($products as $product){
			$product->imageFiles = Images::find()->where(['product_id'=>$product->id])
												->orderBy('pos DESC')
												->all();
		}
		
		return $this->render('products', [
			'products' => $products
		]);
	}
	public function actionProductUpdate($id = 0)
	{
		$request = Yii::$app->request;
		$aOldImages = [];
		$dir_uploads = Yii::$app->params['dirUploads'];
		
		if(!$id){
			$model = new Products();
			$model->is_sale = 0;
			$model->is_hide = 0;
		
		} else {
			$model = Products::findOne($id);
			$aOldImages = Images::find()->where(['product_id' => $id])
										->orderBy('pos DESC')
										->asArray()
										->all();
		}
		
		// если происходит запрос на запись новых данных или обновления данных
		if($request->isPost && $model->load($request->post())){
			if(empty($model->id)){
				$tmp = Yii::$app->db->createCommand("SHOW TABLE STATUS LIKE 'products'")->queryOne();
				$next_id = $tmp['Auto_increment'];
			
			} else {
				$next_id = $model->id;
			}
			
			$model->slug = MyCustom::rus2lat($model->title)."_".$next_id;
			$model->price = intval($model->price);
			$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			$model->imageFiles = array_reverse($model->imageFiles);
            $aNewImages = [];
			
			foreach ($model->imageFiles as $file) {
				$name = str_replace(".", "", strval(microtime(true)))."_".mt_rand(1, 1000).".".$file->extension;
				
				if($file->saveAs($dir_uploads.'/'.$name)){
					$aNewImages[] = $name;
					
					// thumbnail_sm
					Image::getImagine()->open($dir_uploads.'/'.$name)
							->thumbnail(new Box(120, 120))
							->save($dir_uploads.'/thumb_sm_'.$name, ['quality' => 80]);
					
					// thumbnail
					Image::getImagine()->open($dir_uploads.'/'.$name)
							->thumbnail(new Box(310, 310))
							->save($dir_uploads.'/thumb_'.$name, ['quality' => 90]);
					// resize
					Image::getImagine()->open($dir_uploads.'/'.$name)
							->thumbnail(new Box(800, 800))
							->save($dir_uploads.'/'.$name, ['quality' => 100]);
					
//					Image::thumbnail($dir_uploads.'/'.$name, 120, 120)
//							->save(Yii::getAlias($dir_uploads.'/thumb_'.$name), ['quality' => 80]);
				}
            }
			
			$model->imageFiles = null;
			$model->save();
			
			if(sizeof($aNewImages)){
				foreach($aNewImages as $key => $val){
					$Images = new Images();
					$Images->attributes = [
						'product_id' => $model->id,
						'pos' => $key+1,
						'name' => $val,
					];
					$Images->save();
				}
			}
			
			return $this->redirect('/admin/products');
		}
		
		return $this->render('product_update', [
			'model'			=> $model,
			'aOldImages'	=> $aOldImages,
		]);
	}
	public function actionProductDelete($id)
	{
		$result = false;
		$msg = "";
		$path = Yii::$app->params['dirUploads'];
		$product = Products::findOne($id);
		$is_deleted = $product->delete();
		
		if($is_deleted){
			if(Images::find()->where(['product_id' => $id])->count()){
				$images = Images::find()->where(['product_id' => $id])
										->asArray()
										->all();
				
				Images::deleteAll(['product_id' => $id]);
				
				foreach($images as $val){
					if(is_file($path.'/'.$val['name'])){
						unlink($path.'/'.$val['name']);
					}
					if(is_file($path.'/thumb_'.$val['name'])){
						unlink($path.'/thumb_'.$val['name']);
					}
					if(is_file($path.'/thumb_sm_'.$val['name'])){
						unlink($path.'/thumb_sm_'.$val['name']);
					}
				}
				
				$result = true;
			}
			
		} else {
			$msg = 'товар не удалился';
		}
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	public function actionProductImageDelete($id, $name)
	{
		$result = false;
		$msg = "";
		
		$is_deleted = Images::deleteAll(['product_id' => $id, 'name' => $name]);
		
		if($is_deleted){
			$path = Yii::$app->params['dirUploads'];
			
			if(is_file($path.'/'.$name)){
				if(unlink($path.'/'.$name)){
					if(is_file($path.'/thumb_'.$name)){
						unlink($path.'/thumb_'.$name);
					}
					if(is_file($path.'/thumb_sm_'.$name)){
						unlink($path.'/thumb_sm_'.$name);
					}
					
					$result = true;
				
				} else {
					$msg = 'запись удалена, но файл не удалился';
				}
	
			} else {
				$msg = 'запись удалена, но файл не найден';
			}
		
		} else {
			$msg = 'запись не удалилась';
		}
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	
	public function actionComments()
	{
		return $this->render('comments', [
			'items' => Comments::find()->orderBy('id DESC')->all()
		]);
	}
	public function actionCommentUpdate($id = 0)
	{
		$request = Yii::$app->request;
		$dir_uploads = Yii::$app->params['dirUploads'];
		$old_avatar = "";
		
		if(!$id){
			$model = new Comments();
			$model->is_hide = 0;
		
		} else {
			$model = Comments::findOne($id);
			$old_avatar = $model->avatar;
		}
		
		// если происходит запрос на запись новых данных или обновления данных
		if($request->isPost && $model->load($request->post())){
			$avatarImg = UploadedFile::getInstances($model, 'avatar');
				
			if(!empty($avatarImg[0])){
				$name = str_replace(".", "", strval(microtime(true)))."_".mt_rand(1, 1000).".".$avatarImg[0]->extension;
				
				if($avatarImg[0]->saveAs($dir_uploads.'/'.$name)){
					if(!empty($old_avatar) && is_file($dir_uploads.'/'.$old_avatar)){
						unlink($dir_uploads.'/'.$old_avatar);
					}
					
					Image::thumbnail($dir_uploads.'/'.$name, 120, 120)
							->save(Yii::getAlias($dir_uploads.'/'.$name), ['quality' => 90]);
				
					$model->avatar = $name;
				}
			}
	
			$model->save();
			
			return $this->redirect('/admin/comments');
		}
		
		return $this->render('comment_update', [
			'model' => $model,
		]);
	}
	public function actionCommentDelete($id)
	{
		$result = false;
		$msg = "";
		$path = Yii::$app->params['dirUploads'];
		$item = Comments::findOne($id);
		$avatar = $item->avatar;
		$is_deleted = $item->delete();
		
		if($is_deleted){
			if(!empty($avatar) && is_file($path."/".$avatar)){
				unlink($path."/".$avatar);
			}
			
			$result = true;
			
		} else {
			$msg = 'комментарий не удалился';
		}
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	
	public function actionPages()
	{
		return $this->render('pages', [
			'items' => Pages::find()->orderBy('id DESC')->all()
		]);
	}
	public function actionPageUpdate($id = 0)
	{
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		
		if(!$id){
			$model = new Pages();
		
		} else {
			$model = Pages::findOne($id);
		}
		
		// если происходит запрос на запись новых данных или обновления данных
		if($request->isPost && $model->load($request->post())){
			$slug = MyCustom::rus2lat($model->title);
			$Page = Pages::findOne(['slug' => $slug]);
			
			if(
					(empty($model->id) && !empty($Page->id))	
					||
					(!empty($model->id) && !empty($Page) && $Page->id != $model->id)
				){
				$session->addFlash('error', 'смените название заголовка, а то получается дубликат');
			
			} else {
				$model->slug = $slug;
				$model->save();
				return $this->redirect('/admin/pages');
			}
		}
		
		return $this->render('page_update', [
			'model' => $model,
		]);
	}
	public function actionPageDelete($id)
	{
		$result = false;
		$msg = "";
		$path = Yii::$app->params['dirUploads'];
		$item = Pages::findOne($id);
		$text = $item->text;
		$is_deleted = $item->delete();
		
		if($is_deleted){
			// паттерн на нахождение картинков в html-е
			preg_match_all('/<img(?:\\s[^<>]*?)?\\bsrc\\s*=\\s*(?|"([^"]*)"|\'([^\']*)\'|([^<>\'"\\s]*))[^<>]*>/i', $text, $aImgs);
	
			if(!empty($aImgs[1])){
				foreach($aImgs[1] as $val){
					$name = basename($val);
					
					if(is_file($path."/".$name)){
						unlink($path."/".$name);
					}
				}
			}		
			
			$result = true;
			
		} else {
			$msg = 'страница не удалилась';
		}
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => $result, 'msg' => $msg];
	}
	public function actionSettings()
	{
		return $this->render('settings', [
			'items' => Settings::find()->all()
		]);
	}
	public function actionSettingUpdate($id)
	{
		$request = Yii::$app->request;
		$model = Settings::findOne($id);
		
		// если происходит запрос на запись новых данных или обновления данных
		if($request->isPost && $model->load($request->post())){
			$model->save();
			
			return $this->redirect('/admin/settings');
		}
		
		return $this->render('setting_update', [
			'model' => $model
		]);
	}
}
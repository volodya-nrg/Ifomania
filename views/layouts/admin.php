<?
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AdminAppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Администрирование</title>
    <? $this->head() ?>
</head>
<body>
<? $this->beginBody() ?>
	<div class="container-fluid">
		<div class="row">
			<? if(Yii::$app->session->has('admin')): ?>
				<div id="admin-menu" class="col-xs-2">
					<br />
					<h5>Администрирование</h5>
					<hr />
					<ul class="list-unstyled">
						<li><a href="/"><i class="fa fa-home"></i> Главная</a></li>
						<li><a href="<?= Url::to('/admin/products') ?>"><i class="fa fa-clone"></i> Продукты</a></li>
						<li><a href="<?= Url::to('/admin/users') ?>"><i class="fa fa-users"></i> Пользователи</a></li>
						<li><a href="<?= Url::to('/admin/orders') ?>"><i class="fa fa-list"></i> Заказы</a></li>
						<li><a href="<?= Url::to('/admin/comments') ?>"><i class="fa fa-comments"></i> Комментарии</a></li>
						<li><a href="<?= Url::to('/admin/pages') ?>"><i class="fa fa-files-o"></i> Страницы</a></li>
						<li><a href="<?= Url::to('/admin/settings') ?>"><i class="fa fa-cogs"></i> Настройки</a></li>
						<hr />
						<li><a href="<?= Url::to('/admin/logout') ?>"><i class="fa fa-sign-out"></i> Выход</a></li>
						
					</ul>
				</div>
				<div id="admin-content" class="col-xs-10">
					<?= $content ?>
					<br /><br /><br />
				</div>
			
			<? else: ?>
				<?= $content ?>
			<? endif; ?>
		</div>
	</div>
<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>

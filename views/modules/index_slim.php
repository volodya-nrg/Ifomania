<?
use yii\helpers\Url;
?>
<div id="screen-index-slim">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				<a id="screen-index-slim-logo" class="screen-index-slim-cell" href="<?= Url::to(['/']) ?>"></a>
				<div id="screen-index-slim-text" class="screen-index-slim-cell hidden-xs">
					<div class="text-shadow text-bold"><font size="+1">Старт <span class="text-pink">1 января</span></font></div>
					<div class="text-shadow text-bold"><font size="+1">Окончание <span class="text-pink">1 сентября</span></font></div>
				</div>	
			</div>
			<div class="col-xs-12 col-sm-4" align="right">
				<div class="screen-index-slim-cell text-center">
					<a class="soc-icon-cube soc-icon-cube-pink" href="https://vk.com/ifomania" rel="nofollow" target="_blank"><i class="fa fa-vk"></i></a>
					<a class="soc-icon-cube soc-icon-cube-pink" href="https://www.instagram.com/ifomania/" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a>
					<br />
					<br />
					<a class="a-pink" href="<?= Url::to(['/site/cart']) ?>">Корзина</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="a-pink" href="<?= Url::to(['/site/help']) ?>">Тех. поддержка</a>
					<br />
					<? if(Yii::$app->session->has('user')): ?>
						<a class="a-white" href="<?= Url::to(['/profile/index']) ?>">Личный кабинет</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a class="a-white" href="<?= Url::to(['/site/logout']) ?>">Выход</a>
					<? else: ?>
						<a class="a-white" href="javascript: void()" data-toggle="modal" data-target="#pop-up-login">Личный кабинет</a>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
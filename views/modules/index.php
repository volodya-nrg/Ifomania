<?
use yii\helpers\Url;
?>
<div id="screen-index">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<table align="right" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<? if(Yii::$app->session->has('user')): ?>
								<a class="a-white" href="<?= Url::to(['/profile/index']) ?>">Личный кабинет</a>
							<? else: ?>
								<a class="a-white" href="javascript: void()" data-toggle="modal" data-target="#pop-up-login">Личный кабинет</a>
							<? endif; ?>
							<br />
							<a class="a-pink" href="<?= Url::to(['/site/help']) ?>">Тех. поддержка</a>
						</td>
						<td width="20"></td>
						<td>
							<a class="soc-icon-cube soc-icon-cube-pink" href="https://vk.com/ifomania" rel="nofollow" target="_blank" ><i class="fa fa-vk"></i></a>
							<a class="soc-icon-cube soc-icon-cube-pink" href="https://www.instagram.com/ifomania/" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div id="screen-index-title">
					<div class="h2 text-white text-center text-shadow">Такой акции ты еще не видел!</div>
					<div class="h2 text-white text-center text-shadow">
						с <span class="text-pink">1 января</span> по <span class="text-pink">1 сентября 2017 года</span> 
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button id="screen-index-main-btn" class="btn btn-lg btn-gradient" 
						data-toggle="modal" data-target="#pop-up-participate" >Принять участие</button>
			</div>
		</div>
	</div>
</div>
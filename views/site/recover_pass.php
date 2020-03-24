<? $path = __DIR__.'/../modules'; ?>

<? include($path.'/index_slim.php') ?>

<div class="container">
	<div class="row">
		<div class="col-xs-4 col-xs-offset-4">
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<form class="form" action="" role="form" method="post" >
				<? if(Yii::$app->session->hasFlash('error')): ?>
					<div class="alert alert-danger">
						<ul>
							<? foreach(Yii::$app->session->getFlash('error') as $val): ?>
								<li><?= $val ?></li>
							<? endforeach; ?>
						</ul>
					</div>
				<? elseif(Yii::$app->session->hasFlash('success')): ?>
					<div class="alert alert-success">
						На ваш е-мэйл выслано сообщение.<br />Следуйте инструкциям, указанным в письме
					</div>
				<? endif; ?>
				
				<div class="form-group">
					<div class="row">
						<div class="col-xs-12">
							<label class="control-label text-vinous">Впишите ваш е-мэйл</label>
							<input class="form-control" type="text" name="email" required value="" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-12 text-right">
							<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
							<br />
							<button class="btn btn-darkblue" type="submit">Отправить</button>
						</div>
					</div>
				</div>
			</form>
			<div class="clearfix"></div>
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
		</div>
	</div>
</div>

<? include($path.'/footer.php') ?>
<? include($path.'/pop_ups.php') ?>
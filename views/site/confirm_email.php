<? $path = __DIR__.'/../modules'; ?>

<? include($path.'/index_slim.php') ?>

<div class="container">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<? if(!empty($result)): ?>
				<h3>Ваш е-мэйл успешно подтвержден.</h3>
				<h4>Зайдите в свой профиль, используя свой логин и пароль.</h4>
			<? else: ?>
				<h3>Ошибка верификации е-мэйла.</h3>
			<? endif; ?>
		</div>
	</div>
</div>

<? include($path.'/pop_ups.php') ?>
<?
use yii\helpers\Html;

$session = Yii::$app->session;
$old = $session->getFlash('old')[0];
?>
<div id="screen-support">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<h3 class="text-uppercase">Техническая поддержка</h3>
				<br />
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-sm-8 col-md-9">
				<? if($session->hasFlash('error')): ?>
					<div class="alert alert-danger">
						<ul>
							<? foreach($session->getFlash('error') as $val): ?>
								<li><?= $val ?></li>
							<? endforeach; ?>
						</ul>
					</div>
				
				<? elseif($session->hasFlash('success')): ?>
					<div class="alert alert-success">
						Ваше сообщение отправлено. Ожидайте, скоро с Вами свяжутся.
					</div>
				<? endif; ?>
				
				<form class="form" action="" role="form" method="post">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-7">
								<label class="control-label text-vinous">ФИО *</label>
								<input class="form-control" type="text" name="fio" required 
										value="<?= $session->has('user')? $session['user']->firstname." ".$session['user']->lastname." ".$session['user']->middlename: Html::encode($old['fio']) ?>" />
							</div>
							<div class="col-sm-5">
								<label class="control-label text-vinous">Личный номер *</label>
								<input class="form-control" type="text" name="private_number" required
										value="<?= $session->has('user')? $session['user']->id: Html::encode($old['privateNumber']); ?>" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-7">
								<label class="control-label text-vinous">Почта для ответа *</label>
								<input class="form-control" type="email" name="email" required 
										value="<?= $session->has('user')? $session['user']->email: Html::encode($old['email']); ?>" />
							</div>
							<div class="col-sm-5">
								<label class="control-label text-vinous">Телефон *</label>
								<input class="form-control" type="text" name="tel" required
										value="<?= $session->has('user')? $session['user']->tel: Html::encode($old['tel']) ?>" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label class="control-label text-vinous">Ваш вопрос или комментарий *</label>
								<textarea class="form-control" name="message" rows="10" required><?= Html::encode($old['message']); ?></textarea>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12 text-center">
								<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
								<button class="btn btn-darkblue btn-lg" type="submit">Отправить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-4 col-md-3">
				<div class="box-lightgray">
					<div class="h3">ПРИЕМ ЗАЯВОК НА ПОЧТУ <span class="text-pink">23 ЧАСА В СУТКИ</span></div>
					<p><i>Получите доступ к огромной онлайн фонотеке и загружайте бесплатно понравившиеся материалы. Наша библиотека звуков даст вам всё необходимое для работы с аудио материалом.</i></p>
				</div>
				<div class="box-lightgray">
					<div class="h4">ТЕЛЕФОН ТЕХ. ПОДДЕРЖКИ</div>
					<div class="h3 text-pink">23 ЧАСА В СУТКИ</div>
					<p><i>Звонок по России бесплатный!</i></p>
				</div>
				<div class="box-lightgray">
					<div><i>Режим работы тех. поддержки</i></div>
					Пн. - пт. с 9:00 до 23:00
					<br />
					Сб. - вс. с 10:00 до 21:00
					<div><i>По московскому времени</i></div>
				</div>
			</div>
		</div>
		<br />
	</div>
</div>
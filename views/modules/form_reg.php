<?
use yii\helpers\Url;
?>
<form id="form-reg" class="form" role="form" onsubmit="return false;">
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label class="text-vinous">E-mail *</label>
				<input type="text" class="form-control" name="email" required maxlength="100" placeholder="info@ifomania.ru" />
			</div>
			<div class="col-sm-6">
				<label class="text-vinous">Телефон *</label>
				<input type="text" class="form-control" name="tel" required maxlength="20" placeholder="номер сотового телефона" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label class="text-vinous">Пароль *</label>
				<input type="password" class="form-control" required name="pass" placeholder="Ваш секретный пароль" />
			</div>
			<div class="col-sm-6">
				<label class="text-vinous">Пароль (повтор) *</label>
				<input type="password" class="form-control" required name="pass_c" placeholder="Ваш секретный пароль (потвор)" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label class="text-vinous">Имя *</label>
				<input type="text" class="form-control" required name="firstname" maxlength="50" placeholder="Иван" />
			</div>
			<div class="col-sm-6">
				<label class="text-vinous">Фамилия *</label>
				<input type="text" class="form-control" required name="lastname" maxlength="50" placeholder="Иванов" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label class="text-vinous">Отчество *</label>
				<input type="text" class="form-control" required name="middlename" maxlength="50" placeholder="Иванович" />
			</div>
			<div class="col-sm-6">
				<label class="text-vinous">Номер паспорта *</label>
				<input type="text" class="form-control" required name="passport" maxlength="20" placeholder="серия и номер паспорта" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label class="text-vinous">Реферер</label>
				<input type="text" class="form-control" name="referer_url" maxlength="50" placeholder="http://<?= Yii::$app->getRequest()->serverName ?>?referer=ID или ID" />
			</div>
			<div class="col-sm-6">
				<div class="checkbox">
					<br />
					<label>
						<input type="checkbox" required name="is_agree" />
						согласен с <a href="<?= Url::to(['/page/dogovor-oferty']) ?>">договором оферты</a> *
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="alert alert-danger hide"></div>
	<div class="alert alert-success hide"></div>
	<div class="form-group text-center">
		<p class="text-muted"><i>Нажав на кнопку «Написать реферат», вы лично создаете уникальный текст, причем именно от вашего нажатия на кнопку зависит, какой именно текст получится — таким образом, авторские права на реферат принадлежат только вам.</i></p>
		<br />
		<input type="hidden" name="referer" value="<?= !empty(Yii::$app->request->get('referer'))? Yii::$app->request->get('referer'): 0 ?>" />
		<input class="hide" type="reset" />
		<button class="btn btn-gradient" onclick="registrationUser(this)">Зарегистрироваться</button>
	</div>
</form>
					
<?
use yii\helpers\MyCustom;

if(Yii::$app->session->has('user')){
	$aUser = [
		'email'		=> Yii::$app->session['user']['email'],
		'tel'		=> Yii::$app->session['user']['tel'],
		'fio'		=> Yii::$app->session['user']['firstname']." ".Yii::$app->session['user']['lastname']." ".Yii::$app->session['user']['middlename']
	];
	
} else {
	$aUser = [
		'email'		=> '',
		'tel'		=> '',
		'fio'		=> '',
	];
}

?>
<div id="screen-order">
	<form id="form-order" class="form" role="form" onsubmit="return false;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<br />
					<h3 class="text-uppercase">Оформление заказа</h3>
					<br />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="box-lightgray-with-label">
						<div class="box-lightgray-with-label-title">
							Персональные данные
						</div>
						<div class="box-lightgray-with-label-content">
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">Е-мэйл *</div>
									<input class="form-control" type="text" name="email" maxlength="50" required <?= !empty($aUser['email'])? ' value="'.$aUser['email'].'"': '' ?> placeholder="info@ifomania.ru" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">Контактный телефон *</div>
									<input class="form-control" type="text" name="tel" maxlength="20" required <?= !empty($aUser['tel'])? ' value="'.$aUser['tel'].'"': '' ?> placeholder="номер сотового телефона" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">ФИО *</div>
									<input class="form-control" type="text" name="fio" maxlength="50" required <?= !empty($aUser['fio'])? ' value="'.$aUser['fio'].'"': '' ?> placeholder="Иван Иванов Иванович" />
								</div>
							</div>
							<br />
							<p class="text-muted"><i>* — You agree to and are bound by the terms and conditions set forth below and in any modified or additional terms that may publish from time to time.</i></p>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="box-lightgray-with-label">
						<div class="box-lightgray-with-label-title box-lightgray-with-label-title-pink">
							Получение заказа
						</div>
						<div class="box-lightgray-with-label-content">
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">Город *</div>
									<select class="form-control" name="city" required >
										<option value="Москва">Москва</option>
										<option value="Санкт-Питербург">Санкт-Питербург</option>
										<option value="другой город">другой город</option>
									</select>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-xs-12">
									<span class="text-vinous">Доставка курьером *</span>
									<select class="form-control" name="delivery" required >
										<option value="По городу (+350 руб.)">По городу (+350 руб.)</option>
									</select>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">Адрес доставки *</div>
									<input class="form-control" type="text" name="address" maxlength="100" required placeholder="Ваш адрес, куда доставить товары" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-xs-12">
									<div class="text-vinous">Комментарий</div>
									<input class="form-control" type="text" name="comment" maxlength="255" placeholder="Ваш комментарий" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="box-lightgray-with-label">
						<div class="box-lightgray-with-label-title">
							Оплата заказа
						</div>
						<div class="box-lightgray-with-label-content">
							<div class="row hide">
								<div class="col-xs-12">
									<div class="text-vinous">Способ оплаты *</div>
								</div>
							</div>
							<div class="row hide">
								<div class="col-xs-12">
									<div class="checkbox text-uppercase">
										<label><input type="radio" name="payment" value="Банковской картой" checked="checked"> Банковской картой</label>
									</div>
									<div class="checkbox text-uppercase">
										<label><input type="radio" name="payment" value="Наличными"> Наличными</label>
									</div>
									<div class="checkbox text-uppercase">
										<label><input type="radio" name="payment" value="В кредит"> В кредит</label>
									</div>
									<div class="checkbox text-uppercase">
										<label><input type="radio" name="payment" value="Яндекс-деньги"> Яндекс-деньги</label>
									</div>
									<div class="checkbox text-uppercase">
										<label> <input type="radio" name="payment" value="Qiwi"> Qiwi</label>
									</div>
								</div>
							</div>
							<div class="text-center text-bold text-uppercase">
								<font size="+2">К оплате</font>
								<br />
								<font id="total_sum" size="+2" class="text-pink"><?= !empty($total_sum)? MyCustom::htmlPrice($total_sum): 0 ?></font>
								<font size="+2" class="text-pink">руб.</font>
							</div>
							<br />
							<p class="text-muted"><i>Платежи осуществляются через Яндекс-кассу.</i></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<br />
					<div class="alert alert-danger hide"></div>
					<div class="alert alert-success hide"></div>
					<input class="hide" type="reset" />
					<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
					<br />
					<center>
						<button class="btn btn-darkblue btn-lg hidden-xs" onclick="setOrder(this)">Оформить заказ<?= !empty($show_btn_with_sale)? ' и принять участие в акции': '' ?></button>
						<button class="btn btn-darkblue visible-xs" onclick="setOrder(this)">Оформить заказ<?= !empty($show_btn_with_sale)? ' и<br /> принять участие в акции': '' ?></button>
					</center>
					<br />
					<br />
					<br />
				</div>
			</div>
		</div>
	</form>
</div>
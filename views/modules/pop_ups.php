<?
use yii\helpers\Url;
?>
<div id="pop-up-get-your-prize" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
				<div class="h4 text-uppercase text-center">Получить свой суперприз</div>
				<br />
				<p class="text-muted text-center"><i>Нажав на кнопку «Написать реферат», вы лично создаете уникальный текст, причем именно от вашего нажатия на кнопку зависит. Пуантилизм, зародившийся в музыкальных микроформах начала ХХ столетия, нашел далекую историческую параллель в лице средневекового гокета, однако нота сонорна.</i></p>
				<br />
				<form id="form-get-your-prize" class="form" action="" role="form" onsubmit="return false;">
					<div class="alert alert-danger hide"></div>
					<div class="alert alert-success hide"></div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="text-vinous">Город *</label>
								<select class="form-control" name="city" required>
									<option value=""></option>
									<option value="Москва">Москва</option>
									<option value="Санкт-Питербург">Санкт-Питербург</option>
								</select>
							</div>	
							<div class="form-group">
								<label class="text-vinous">Доставка курьером *</label>
								<select class="form-control" name="delivery" required>
									<option value=""></option>
									<option value="Почтой">Почтой</option>
									<option value="По городу (+350 руб.)">По городу (+350 руб.)</option>
								</select>
							</div>
							<div class="form-group">
								<label class="text-vinous">Адрес доставки *</label>
								<input type="text" class="form-control" name="address" required placeholder="Ваш адрес, куда доставить подарок" />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="text-vinous">Комментарий</label>
								<textarea class="form-control" name="comment" placeholder="Ваш комментарий"></textarea>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="text-vinous">Время доставки</label>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="text-vinous col-xs-6">Доставить с:</label>
									<div class="col-xs-3">
										<input class="form-control" type="text" name="dostavit_s_hour" placeholder="0" />
									</div>
									<div class="col-xs-3">
										<input class="form-control" type="text" name="dostavit_s_min" placeholder="0" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="text-vinous col-xs-6">Доставить до:</label>
									<div class="col-xs-3">
										<input class="form-control" type="text" name="dostavit_do_hour" placeholder="0" />
									</div>
									<div class="col-xs-3">
										<input class="form-control" type="text" name="dostavit_do_min" placeholder="0" />
									</div>
								</div>	
							</div>
							<div class="form-group">
								<div class="row">
									<label class="text-vinous col-xs-6">Дата доставки:</label>
									<div class="col-xs-6">
										<input class="form-control" type="text" name="data_dostavki" placeholder="0000-00-00" />
									</div>
								</div>	
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12">
										<p class="text-muted text-center"><i>Нажав на кнопку «Написать реферат», вы лично создаете уникальный текст.</i></p>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<input class="hide" type="reset" />
							<button class="btn btn-gradient btn-lg" onclick="setOrderGiveGift(this)">Получить свой супер приз</button>
						</div>
					</div>
				</form>
				<br />
			</div>
		</div>
	</div>
</div>

<div id="pop-up-login" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="h4 text-uppercase text-center">Войти</div>
						<br />
						<form id="form-login" class="form" role="form" onsubmit="return false;">
							<div class="alert alert-danger hide"></div>
							<div class="alert alert-success hide"></div>
							<div class="form-group">
								<label class="text-vinous">E-mail *</label>
								<input type="text" class="form-control" name="email" maxlength="100" placeholder="электронная почта" />
							</div>
							<div class="form-group">
								<label class="text-vinous">Пароль *</label>
								<input type="password" class="form-control" name="pass" placeholder="Ваш секретный пароль" />
							</div>
							<div class="form-group text-center">
								<input class="hide" type="reset" />
								<br />
								<button class="btn btn-darkblue btn-block" onclick="login(this)">Войти</button>
								<br />
								<br />
								<a class="a-vinous" href="/recover-pass">Восстановить пароль</a>
							</div>
						</form>
					</div>
					<div class="col-sm-8">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
						<div class="h4 text-uppercase text-center">Регистрация нового участника</div>
						<br />
						<?= $this->render('@app/views/modules/form_reg'); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="pop-up-participate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
				<div class="text-center">
					<div class="h4 text-uppercase">
						Принять участие в акции 
						<span id="text-18-plus-wrapper">
							<div id="text-18-plus" class="text-pink text-bold">18 +</div>
						</span>
					</div>
					<br />
					<p class="text-muted">Для покупки товара по акции необходимо зарегистрироваться и автоматически принять участие в нашей супер акции.</p>
					<br />
					<button class="btn btn-gradient btn-lg"
							onclick="
								$('#pop-up-participate').modal('toggle');
								setTimeout(function(){
									$('#pop-up-reg').modal('toggle');
								}, 500);
							" >Зарегистрироваться</button>
					<br />
					<br />
					<p class="text-muted">Глиссандо, в том числе, синхронно имитирует алеаторически выстроенный бесконечный канон с полизеркальной векторно-голосовой структурой. Алеаединица.</p>
				</div>
				<hr class="hr-dashed" />
				<div id="pop-up-how-start">
					<div class="h5 text-center text-uppercase">Правила нашей акции просты как раз, два, три</div>
					<div class="row">
						<div class="col-xs-3 text-center">
							<div class="screen-how-start-block screen-how-start-block-sm">
								<div class="screen-how-start-block-cover">
									<img class="img-responsive" src="/img/how_start_1.png" />
								</div>
								<div class="screen-how-start-block-desc">
									<h5 class="text-center">MEETUP IN COPENHAGEN</h5>
								</div>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<br /><br /><br />
							<div class="screen-how-start-block screen-how-start-block-sm">
								<div class="screen-how-start-block-cover">
									<img class="img-responsive" src="/img/how_start_2.png" />
								</div>
								<div class="screen-how-start-block-desc">
									<h5 class="text-center">MEETUP IN COPENHAGEN</h5>
								</div>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<br /><br />
							<div class="screen-how-start-block screen-how-start-block-sm">
								<div class="screen-how-start-block-cover">
									<img class="img-responsive" src="/img/how_start_3.png" />
								</div>
								<div class="screen-how-start-block-desc">
									<h5 class="text-center">MEETUP IN COPENHAGEN</h5>
								</div>
							</div>
						</div>
						<div class="col-xs-3 text-center">
							<br /><br /><br /><br />
							<div class="screen-how-start-block screen-how-start-block-sm">
								<div class="screen-how-start-block-cover">
									<img class="img-responsive" src="/img/how_start_4.png" />
								</div>
								<div class="screen-how-start-block-desc">
									<h5 class="text-center">MEETUP IN COPENHAGEN</h5>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="pop-up-reg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
				<div class="h4 text-uppercase text-center">Регистрация нового участника</div>
				<br />
				<?= $this->render('@app/views/modules/form_reg'); ?>
			</div>
		</div>
	</div>
</div>

<div id="pop-up-tovar-added" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body text-center">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
				<div class="h4 text-uppercase">Товар добавлен в корзину</div>
				<br />
				<button class="btn btn-darkblue" data-dismiss="modal" aria-hidden="true">Продолжить покупки</button>
				<a class="btn btn-darkblue" href="<?= Url::to(['site/cart']) ?>">Перейти в корзину</a>
				<br />
				<br />
			</div>
		</div>
	</div>
</div>
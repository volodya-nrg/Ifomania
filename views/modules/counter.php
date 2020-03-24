<?
use yii\helpers\Url;
?>
<div id="screen-counter">
	<div id="screen-counter-pink-shadow"></div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1">
				<br />
				<div align="center">
					<div class="screen-counter-block screen-counter-block-1">
						<div class="screen-counter-block-left">
							Уже более человек приняло участие в акции
						</div>
						<div class="screen-counter-block-right"><?= $total_participants ?></div>
					</div>
					<div class="screen-counter-block screen-counter-block-2">
						<div class="screen-counter-block-left">
							Мы выдали уже более "подарков"
						</div>
						<div class="screen-counter-block-right"><?= $total_sent_gifts ?></div>
					</div>
				</div>
				<div align="center">
					<font class="text-muted text-uppercase" size="+1">
						и их число растет с каждой минутой
					</font>
				</div>
				<br />
				<div id="screen-counter-field">
					<table border="0" align="center" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td class="hidden-xs" align="center" valign="middle" width="*">
								<p>Всё больше людей узнают о нас от своих друзей, знакомых, близких!</p>	
							</td>
							<td width="10"></td>
							<td align="center" valign="top" width="450">
								<div class="counter-field-tablo">
									<div class="counter-field-tablo-wrapper">
										<div class="h3 text-center text-uppercase">Осталось до конца акции</div>
										<div class="text-muted text-center text-uppercase">
											Начало акции 1 января 2017 года!
										</div>
										<br />
										<table cellspacing="0" cellpadding="0" width="100%">
											<thead>
												<th width="*">
													<div class="text-pink text-uppercase text-bold text-center">Дни</div>	
												</th>
												<th width="20"></th>
												<th width="104">
													<div class="text-pink text-uppercase text-bold text-center">Часы</div>	
												</th>
												<th width="10"></th>
												<th width="104">
													<div class="text-pink text-uppercase text-bold text-center">Минуты</div>	
												</th>
											</thead>
											<tbody>
												<tr>
													<td class="counter-td-days" align="center" valign="middle">
														<div class="counter-item">0</div>
														<div class="counter-item">0</div>
														<div class="counter-item">0</div>
													</td>
													<td></td>
													<td class="counter-td-hours" align="center" valign="middle">
														<div class="counter-item">0</div>
														<div class="counter-item">0</div>
													</td>
													<td align="center" valign="middle">
														<font class="text-muted" size="+3">:</font>
													</td>
													<td class="counter-td-minutes" align="center" valign="middle">
														<div class="counter-item">0</div>
														<div class="counter-item">0</div>
													</td>
												</tr>	
											</tbody>
										</table>
										<div class="clearfix"></div>
										<br />
										<div align="center">
											<font class="text-muted text-uppercase">Окончание акции 1 сентября 2017 года!</font>
										</div>
										<br />
									</div>
								</div>
							</td>
							<td width="10"></td>
							<td class="hidden-xs" align="center" valign="middle" width="*">
								<p>Ни один участник не будет обдилен нашим вниманием!</p>
								<p><strong><font size="+1">«Подарок» каждому участнику</font></strong></p>
							</td>
						</tr>
					</table>
					<div align="center">
						<img id="counter-shadow" height="55" src="/img/counter-shadow.png" />
					</div>
				</div>
				<div class="text-center">
					<button class="btn btn-lg btn-gradient" data-toggle="modal" data-target="#pop-up-participate">Принять участие</button>
					<br /><br />
					<a class="a-vinous" href="<?= Url::to(['/page/ob-aktsii']) ?>"><i>Подробнее об акции</i></a>
				</div>
				<br />
				<br />
			</div>
		</div>
	</div>
</div>
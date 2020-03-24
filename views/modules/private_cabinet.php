<?
use yii\helpers\Url;
use app\models\Users;

$User = Yii::$app->session->get('user');
?>
<div id="screen-private-cabinet">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<h3 class="text-uppercase">Личный кабинет</h3>
				<br />
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="text-uppercase text-bold">
					<?= $User->firstname ?>
					<?= $User->lastname ?>
					<?= $User->middlename ?>
				</div>
				<br />
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top">
							<? if(!empty($User->avatar)): ?>
								<img class="img-rounded" width="140" height="140" 
									 src="/uploads/<?= $User->avatar ?>" />
							
							<? else: ?>
								<img class="img-rounded" width="140" height="140" src="/img/avatar-empty.jpg" />
							<? endif; ?>
							<br />
							<br />
							<form action="/profile/set-avatar" method="post" enctype="multipart/form-data">
								<label class="btn btn-default btn-sm btn-file" title="выберите изображение">
									<span>Выбрать файл</span>
									<input type="file" name="avatar" onChange="file_input_onchange(this)" />
									<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
									<input type="hidden" name="page" value="<?= Url::current() ?>" />
								</label>
								<button class="btn btn-sm btn-pink" disabled type="submit"><i class="fa fa-upload"></i></button>
							</form>
						</td>
						<td width="20"></td>
						<td align="left" valign="top">
							<br />
							<br />
							<span class="text-muted">Личный номер:</span> <?= $User->id ?>
							<br />
							<div class="text-muted">Реферальная ссылка:</div>
							<a class="a-pink text-bold" href="http://<?= Yii::$app->getRequest()->serverName ?>?referer=<?= $User->id ?>">http://<?= Yii::$app->getRequest()->serverName ?>?referer=<?= $User->id ?></a>
						</td>
					</tr>
				</table>
			</div>
			<p class="visible-xs visible-sm">&nbsp;</p>
			<div class="col-md-8">
				<div class="row">
					<div class="col-sm-8">
						
						<div class="text-uppercase text-bold text-center"><font size="+1">твое время пришло!</font></div>
						<div class="text-uppercase text-center text-muted">один месяц на исполнение</div>
						<br />
						<div class="counter-field-tablo">
							<div class="counter-field-tablo-wrapper">
								<table border="0" align="right" cellspacing="0" cellpadding="0" width="100%">
									<thead>
										<th align="center" width="*">
											<div class="text-pink text-uppercase text-center">дни</div>	
										</th>
										<th width="20"></th>
										<th align="center" width="104">
											<div class="text-pink text-uppercase text-center">часы</div>	
										</th>
										<th width="10"></th>
										<th align="center" width="104">
											<div class="text-pink text-uppercase text-center">минуты</div>	
										</th>
									</thead>
									<tbody>
										<tr>
											<td class="counter-td-days" align="center" valign="middle">
												<? if(!empty($aTimeTablo['days'])): ?>
													<? foreach($aTimeTablo['days'] as $val): ?>
														<div class="counter-item"><?= $val ?></div>
													<? endforeach; ?>
												<? else: ?>
													<div class="counter-item">0</div>	
												<? endif; ?>
											</td>
											<td></td>
											<td class="counter-td-hours" align="center" valign="middle">
												<? if(!empty($aTimeTablo['days'])): ?>
													<? foreach($aTimeTablo['hours'] as $val): ?>
														<div class="counter-item"><?= $val ?></div>
													<? endforeach; ?>
												<? else: ?>
													<div class="counter-item">0</div>
													<div class="counter-item">0</div>	
												<? endif; ?>
											</td>
											<td align="center" valign="middle">
												<font class="text-muted" size="+3">:</font>
											</td>
											<td class="counter-td-minutes" align="center" valign="middle">
												<? if(!empty($aTimeTablo['days'])): ?>
													<? foreach($aTimeTablo['mins'] as $val): ?>
														<div class="counter-item"><?= $val ?></div>
													<? endforeach; ?>
												<? else: ?>
													<div class="counter-item">0</div>
													<div class="counter-item">0</div>	
												<? endif; ?>
											</td>
										</tr>	
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="screen-private-cabinet-links" class="col-sm-4">
						<br class="hidden-xs" />
						<br class="hidden-xs" />
						<br />
						<a class="a-gray text-uppercase" href="<?= Url::to(['/site/catalog']) ?>">Каталог</a>
						<br />
						<? if(Url::current() === '/profile/purchases'): ?>
							<span class="text-pink text-uppercase">Мои покупки</span>

						<? else: ?>
							<a class="a-gray text-uppercase" href="<?= Url::to(['/profile/purchases']) ?>">Мои покупки</a>	
						<? endif; ?>
						<br />	
						<? if(Url::current() === '/profile/friends'): ?>
							<span class="text-pink text-uppercase">Мои друзья</span>

						<? else: ?>
							<a class="a-gray text-uppercase" href="<?= Url::to(['/profile/friends']) ?>">Мои друзья</a>	
						<? endif; ?>
						<br />
						<a class="a-gray text-uppercase" href="<?= Url::to(['/page/ob-aktsii']) ?>">Правила акции</a>
						<br />
						<a class="a-gray text-uppercase" href="<?= Url::to(['/site/help']) ?>">Тех. поддержка</a>
					</div>
				</div>	
			</div>
		</div>
		<br />
	</div>
</div>

<? if(Users::showPopupForGiveGift($User->id)): ?>
	<script>
		function myReady() {
			$('#pop-up-get-your-prize').modal('show');
		}
		document.addEventListener("DOMContentLoaded", myReady);
	</script>
<? endif; ?>
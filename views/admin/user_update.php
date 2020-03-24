<?php
use yii\helpers\Url;
use yii\helpers\MyCustom;

use app\models\Products;
use app\models\Images;
?>
<br />
<a href="<?= Url::to('/admin/users') ?>">назад</a>
<br />
<h3><?= $model->firstname ?> <?= $model->lastname ?> <?= $model->middlename ?></h3>
<br />
<table class='table table-striped table-bordered'>
	<tr>
		<td width="300">
			E-mail:
		</td>
		<td>
			<?= $model->email; ?>
		</td>
	</tr>
	<tr>
		<td>
			Серия и номер паспорта:
		</td>
		<td>
			<?= $model->passport; ?>
		</td>
	</tr>
	<tr>
		<td>
			Номер телефона:
		</td>
		<td>
			<?= $model->tel; ?>
		</td>
	</tr>
	<tr>
		<td>
			Реферер:
		</td>
		<td>
			<?= $model->referer; ?>
		</td>
	</tr>
	<tr>
		<td>
			Дата регистрации:
		</td>
		<td>
			<?= $model->ts; ?>
		</td>
	</tr>
	<tr>
		<td>
			Учавствует в акции:
		</td>
		<td>
			<?= $model->akciya_is_started? "Да": "Нет"; ?>
		</td>
	</tr>
	<tr>
		<td>
			Время окончания акции:
		</td>
		<td>
			<?= $model->akciya_time_end? date("Y-m-d H:i:s", $model->akciya_time_end): ""; ?>
		</td>
	</tr>
	<tr>
		<td>
			Данные оставленные для получения подарка:
		</td>
		<td>
			<? if(!empty($aDataOnGiveGift)): ?>
				Время: <?= $aDataOnGiveGift['ts'] ?>
				<br />
				<?= nl2br($aDataOnGiveGift['comment']); ?>
			<? endif; ?>
		</td>
	</tr>
</table>

<? if(!empty($aOrders)): ?>
	<div class="row">
		<div class="col-xs-12">
			<h4>Количество заказов: <?= sizeof($aOrders) ?></h4>
		</div>
	</div>
	<? foreach($aOrders as $Order): ?>
		<div class="row">
			<div class="col-xs-12">
				<h5>Заказ № <?= $Order->id ?></h5>
				<table>
					<tr>
						<td align="left" valign="top">
							E-mail: <?= $Order->email ?><br />
							Номер телефона: <?= $Order->tel ?><br />
							ФИО: <?= $Order->fio ?><br />
							Город: <?= $Order->city ?>
						</td>
						<td width="20"></td>
						<td align="left" valign="top">
							Доставка: <?= $Order->delivery ?><br />
							Адрес: <?= $Order->address ?><br />
							Оплата: <?= $Order->payment ?>
						</td>
						<td width="20"></td>
						<td align="left" valign="top">
							Комментарий: <?= $Order->comment ?><br />
							Время заказа: <?= $Order->ts ?><br />
							Заказ оплачен: <?= !empty($Order->is_paid)? '<font class="text-success" size="+2">Да</font>': '<font class="text-danger" size="+2">Нет</font>' ?>
						</td>
					</tr>
				</table>
				<br />
				<?
					$products = [];
					foreach(explode('|', $Order->products) as $val){
						list($product_id, $amount) = explode(":", $val);

						$objProduct = Products::findOne((int)$product_id);
						$objProduct->imageFiles = Images::find()->where(['product_id' => $objProduct->id])
																->orderBy('pos DESC')
																->all();
						$products[] = ['data' => $objProduct, 'total' => (int)$amount];
					}
				?>
				<table class='table table-striped table-bordered table-condensed'>
					<thead>
						<tr>
							<th>
								Фото
							</th>
							<th>
								Название
							</th>
							<th>
								Цена за 1 шт.
							</th>
							<th>
								Кол-во
							</th>
							<th>
								Сумма
							</th>
						</tr>
					</thead>
					<tbody>
						<? foreach($products as $product): ?>
							<tr>
								<td>
									<? if(!empty($product['data']->imageFiles[0])): ?>
										<img height="30" 
											 src="<?= Url::to('/uploads/thumb_'.$product['data']->imageFiles[0]->name, true) ?>" />

									<? else: ?>
										<img height="30" src="<?= Url::to('/img/cover_empty.jpg', true) ?>" />
									<? endif; ?>
								</td>
								<td>
									<a href="<?= Url::to('/'.$product['data']->slug, true) ?>" target="_blank">
										<?= $product['data']->name ?>
									</a>	
								</td>
								<td>
									<?= MyCustom::htmlPrice($product['data']->price) ?> руб.
								</td>
								<td>
									<?= $product['total'] ?> шт.
								</td>
								<td>
									<?= MyCustom::htmlPrice($product['data']->price * $product['total']) ?> руб.
								</td>
							</tr>
						<? endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td align="right" colspan="5">
								Общая сумма: <font size="+1"><?= MyCustom::htmlPrice($Order->total_sum) ?></font> руб.
							</td>
						</tr>
					</tfoot>
				</table>	
			</div>
		</div>
	<? endforeach; ?>
	
<? endif; ?>

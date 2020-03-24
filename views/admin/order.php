<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\MyCustom;
?>
<br />
<a href="<?= Url::to('/admin/orders') ?>">назад</a>
<br />
<h3>Заказ №<?= $Order->id ?></h3>
<hr />
<font class="text-muted">Е-мэйл:</font> <strong><?= $Order->email ?></strong><br />
<font class="text-muted">Номер телефона:</font> <strong><?= $Order->tel ?></strong><br />
<font class="text-muted">ФИО:</font> <strong><?= $Order->fio ?></strong><br />
<font class="text-muted">Город:</font> <strong><?= $Order->city ?></strong><br />
<font class="text-muted">Доставка:</font> <strong><?= $Order->delivery ?></strong><br />
<font class="text-muted">Адрес:</font> <strong><?= $Order->address ?></strong><br />
<font class="text-muted">Способ оплаты:</font> <strong><?= $Order->payment ?></strong><br />
<font class="text-muted">Сумма цены товаров:</font> <strong><?= MyCustom::htmlPrice($Order->total_sum) ?> руб.</strong><br />
<font class="text-muted">Сумма доставки:</font> <strong><?= MyCustom::htmlPrice($Order->delivery_sum) ?> руб.</strong><br />
<font class="text-muted">Комментарий:</font> <strong><?= $Order->comment ?></strong><br />
<font class="text-muted">Покупатель:</font> <strong><?= $Order->user_id? 'id '.$Order->user_id: 'Гость' ?></strong><br />
<font class="text-muted">Статус:</font> <strong><?= empty($Order->is_payed)? 'НЕ ОПЛАЧЕН': 'ОПЛАЧЕН' ?></strong><br />
<font class="text-muted">Время заказа:</font> <strong><?= $Order->ts ?></strong>
<hr />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th class="text-center" width="50">ID</th>
		<th class="text-center" width="50">Фото</th>
		<th class="text-center">Название</th>
		<th class="text-center" width="100">Цена 1 шт.</th>
		<th class="text-center" width="80">Кол-во</th>
		<th class="text-center" width="120">Сумма</th>
	</thead>
	<tbody>
		<? foreach($aProducts as $val): ?>
			<? 
				$product = $val['product'];
				$amount = $val['amount'];
			?>
			<tr>
				<td align="center">
					<?= $product->id ?>
				</td>
				<td align="center">
					<? if(!empty($product->imageFiles)): ?>
						<img align="absmiddle" height="30" src="/uploads/thumb_sm_<?= $product->imageFiles[0]->name ?>" />
					<? else: ?>
						<img align="absmiddle" height="30" src="/img/cover_empty.jpg" />
					<? endif; ?>
				</td>
				<td valign="middle">
					<a href="/<?= $product->slug ?>" target="_blank"><?= $product->name ?></a>
				</td>
				<td align="center">
					<?= MyCustom::htmlPrice($product->price) ?> руб.
				</td>
				<td align="center">
					<?= $amount ?>
				</td>
				<td align="center">
					<?= MyCustom::htmlPrice($product->price * $amount) ?> руб.
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
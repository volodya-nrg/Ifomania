<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\MyCustom;
?>
<h3>Заказы</h3>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th class="text-center" width="40">Id</th>
			<th class="text-center">Email</th>
			<th class="text-center" width="100">Гость/User</th>
			<th class="text-center" width="120">Tel</th>
			<th class="text-center" width="120">Total Sum</th>
			<th class="text-center" width="150">Ts</th>
			<th width="40"></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($orders as $order): ?>
			<tr>
				<td align="center">
					<?= $order->id ?>
				</td>
				<td>
					<?= $order->email ?>
				</td>
				<td>
					<?= $order->user_id? '': 'Гость' ?>
				</td>
				<td>
					<?= $order->tel ?>
				</td>
				<td align="center">
					<?= MyCustom::htmlPrice($order->total_sum) ?> руб.
				</td>
				<td align="center">
					<?= $order->ts ?>
				</td>
				<td align="center">
					<a href="<?= Url::to('/admin/orders/'.$order->id) ?>"><i class="fa fa-eye"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
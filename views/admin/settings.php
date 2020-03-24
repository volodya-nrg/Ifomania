<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<h3>Настройки</h3>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th class="text-center" width="300">Ключ</th>
		<th class="text-center">Значение</th>
		<th width="100"></th>
	</thead>
	<tbody>
		<? foreach($items as $item): ?>
			<tr >
				<td align="left">
					<?= $item->keyword ?>
				</td>
				<td align="left">
					<?= $item->value ?>
				</td>
				<td align="center">
					<a href="<?= Url::to('/admin/settings/'.$item->id.'/edit') ?>"><i class="fa fa-edit fa-fw"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
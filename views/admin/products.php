<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\MyCustom;
?>
<h3>Продукты</h3>
<div align="right">
	<a class="btn btn-primary" title="Добавить" href="<?= Url::to('/admin/products/create') ?>"><i class="fa fa-plus"></i></a>
</div>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th class="text-center" width="50">ID</th>
		<th class="text-center" width="50">Фото</th>
		<th class="text-center">Название</th>
		<th class="text-center" width="100">Цена</th>
		<th class="text-center" width="80">Акция</th>
		<th></th>
	</thead>
	<tbody>
		<? foreach($products as $product): ?>
			<tr <?= $product->is_hide? 'style="opacity: 0.3"': '' ?> >
				<td align="center">
					<?= $product->id ?>
				</td>
				<td align="center">
					<? if(!empty($product->imageFiles)): ?>
						<img height="30" src="/uploads/thumb_sm_<?= $product->imageFiles[0]->name ?>" />
					<? else: ?>
						<img height="30" src="/img/cover_empty.jpg" />
					<? endif; ?>
				</td>
				<td valign="middle">
					<?= $product->name ?>
				</td>
				<td align="center">
					<?= MyCustom::htmlPrice($product->price) ?> руб.
				</td>
				<td align="center">
					<?= $product->is_sale? "да": ""; ?>
				</td>
				<td align="center">
					<a href="<?= Url::to('/admin/products/'.$product->id.'/edit') ?>"><i class="fa fa-edit fa-fw"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
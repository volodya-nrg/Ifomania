<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<h3>Страницы</h3>
<div align="right">
	<a class="btn btn-primary" title="Добавить" href="<?= Url::to('/admin/pages/create') ?>"><i class="fa fa-plus"></i></a>
</div>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th class="text-center" width="50">Id</th>
		<th class="text-left" width="*">Загаловок</th>
		<th width="50"></th>
	</thead>
	<tbody>
		<? foreach($items as $item): ?>
			<tr>
				<td align="center">
					<?= $item->id ?>
				</td>
				<td valign="middle">
					<?= $item->title ?>
				</td>
				<td align="center">
					<a href="<?= Url::to('/admin/pages/'.$item->id.'/edit') ?>"><i class="fa fa-edit fa-fw"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
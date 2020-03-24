<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<h3>Комментарии</h3>
<div align="right">
	<a class="btn btn-primary" title="Добавить" href="<?= Url::to('/admin/comments/create') ?>"><i class="fa fa-plus"></i></a>
</div>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th class="text-center" width="50">ID</th>
		<th class="text-center" width="50">Фото</th>
		<th class="text-center" width="200">ФИО</th>
		<th class="text-center" width="*">Текст</th>
		<th width="50"></th>
	</thead>
	<tbody>
		<? foreach($items as $item): ?>
			<tr <?= $item->is_hide? 'style="opacity: 0.3"': '' ?> >
				<td align="center">
					<?= $item->id ?>
				</td>
				<td align="center">
					<? if(!empty($item->avatar)): ?>
						<img align="absmiddle" height="30" src="/uploads/<?= $item->avatar ?>" />
					<? else: ?>
						<img align="absmiddle" height="30" src="/img/avatar_empty_man.jpg" />
					<? endif; ?>
				</td>
				<td valign="middle">
					<?= $item->fio ?>
				</td>
				<td valign="middle">
					<?= $item->text ?>
				</td>
				<td align="center">
					<a href="<?= Url::to('/admin/comments/'.$item->id.'/edit') ?>"><i class="fa fa-edit fa-fw"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
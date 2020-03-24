<?
use yii\helpers\Url;
?>
<h3>Пользователи</h3>
<div align="right">
	<small class="text-muted">* полупрозначные - пользователи с неподтвержденными е-мэйлами</small>
	<br />
	<small class="text-muted">* зеленые - пользователи учавствующие в акции</small>
	<br />
	<small class="text-muted">* оранжевые - пользователи, каторые заполнили форму на получение подарка</small>
	<br />
	<small class="text-muted">* серые - пользователи у которых акция просрочелась</small>
</div>
<br />
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th class="text-center" width="50">Id</th>
			<th width="50">Аватар</th>
			<th>Е-мэйл</th>
			<th>ФИО</th>
			<th>Паспорта</th>
			<th>Телефон</th>
			<th>Акция</th>
			<th width="150">Время конца акции</th>
			<th width="150">Время рег-ии</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($users as $user): ?>
			<?
				$style = '';
				
				if(!empty($user->email_secret_key)){
					$style = 'opacity: 0.3';
				
				} elseif($user->akciya_is_started) {
					if($user->akciya_time_end == 0){
						$style = 'background-color: orange;';
					
					} elseif(!empty($user->akciya_time_end) && ($user->akciya_time_end - time() > 0)){
						$style = 'background-color:lightgreen';
					
					} else {
						$style = 'background-color:lightgray';
					}
				}
			?>
			<tr style="<?= $style ?>">
				<td align="center">
					<?= $user->id ?>
				</td>
				<td align="center">
					<? if(!empty($user->avatar)): ?>
						<img height="30" src="/uploads/<?= $user->avatar ?>" />
					<? else: ?>
						<img height="30" src="/img/avatar_empty_man.jpg" />
					<? endif; ?>
				</td>
				<td>
					<?= $user->email ?>
				</td>
				<td>
					<?= $user->firstname." ".$user->lastname." ".$user->middlename ?>
				</td>
				<td>
					<?= $user->passport ?>
				</td>
				<td>
					<?= $user->tel ?>
				</td>
				<td align="center">
					<?= $user->akciya_is_started ?>
				</td>
				<td>
					<?= !empty($user->akciya_time_end)? date("Y-m-d H:i", $user->akciya_time_end): '' ?>
				</td>
				<td>
					<?= $user->ts ?>
				</td>
				<td>
					<a href="<?= Url::to('/admin/users/'.$user->id.'/edit') ?>"><i class="fa fa-eye fa-fw"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
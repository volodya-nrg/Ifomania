<?
use app\models\Users;

$User = Yii::$app->session->get('user');
?>
<p>Вместе с рядом вымерших видов человек разумный образует род люди социометрический побочный PR-эффект.</p>
<br />
<font class="text-sverh-bold"><?= $totalFriendsInAckiya * 10 ?>%</font>
<br />
<div class="h3 text-uppercase">накопленно</div>
<br />
<p>Накопи 100% и получи гарантированный приз</p>
<br />
<div id="iphone-circle-pink">
	<? if(Users::isAlreadySentRequestToTheReceiptOfGift($User->id)): ?>
		<div class="alert alert-success">
			<font size="+2">Заявка принята</font>
		</div>
	
	<? elseif($User->akciya_is_started && $User->akciya_time_end && ($User->akciya_time_end - time() <= 0)): ?>
		<div class="alert alert-danger">
			<font size="+2">Акция просрочена</font>
		</div>
	
	<? else: ?>
		<button class="btn btn-gradient btn-block visible-xs visible-sm" 
			<?= $totalFriendsInAckiya >= 10? '': 'disabled' ?>
			data-toggle="modal" data-target="#pop-up-get-your-prize" >получить приз</button>
		<button class="btn btn-gradient btn-block btn-lg hidden-xs hidden-sm" 
			<?= $totalFriendsInAckiya >= 10? '': 'disabled' ?>
			data-toggle="modal" data-target="#pop-up-get-your-prize" >получить приз</button>
	<? endif; ?>
</div>
<br />
<br />
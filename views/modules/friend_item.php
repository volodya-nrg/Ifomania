<div class="friend-item" <?= isset($item) && empty($item->akciya_is_started)? 'style="opacity: 0.2;"': ''; ?> >
	<a>
		<? if(!empty($item->avatar)): ?>
			<img class="img-rounded" width="140" height="140" src="/uploads/<?= $item->avatar ?>" />
		<? elseif(!empty($item)): ?>
			<img class="img-rounded" width="140" height="140" src="/img/avatar_empty_man-2.jpg" />	
		<? else: ?>
			<img class="img-rounded" width="140" height="140" src="/img/avatar_empty_man.jpg" />
		<? endif; ?>
	</a>
	<div class="friend-item-title text-eclipse" 
		 title="<?= !empty($item->firstname)? $item->firstname: '' ?><?= !empty($item->lastname)? ' '.$item->lastname: '' ?>">
		<?= !empty($item->firstname)? $item->firstname: 'Имя' ?> 
		<?= !empty($item->lastname)? $item->lastname: 'Фамилия' ?>
	</div>
	<div class="friend-item-friends text-thin text-muted">
		друзей: 
		<strong><?= !empty($item->total_friends)? $item->total_friends: 0 ?></strong>
	</div>
</div>
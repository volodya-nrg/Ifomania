<div id="screen-my-friends">
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<br />
				<h3 class="text-uppercase">Мои друзья</h3>
				<br />
				<? foreach($aFriends as $friend): ?>
					<?= $this->render('@app/views/modules/friend_item', ['item' => $friend]); ?>
				<? endforeach; ?>
				
				<? if(sizeof($aFriends) < 10): ?>
					<? for($i=0; $i< (10 - sizeof($aFriends)); $i++): ?>
						<?= $this->render('@app/views/modules/friend_item'); ?>
					<? endfor; ?>
				<? endif; ?>
			</div>
			<div class="col-sm-3 text-center">
				<br />
				<br />
				<? include(__DIR__.'/sidebar.php'); ?>
			</div>
		</div>
	</div>
</div>
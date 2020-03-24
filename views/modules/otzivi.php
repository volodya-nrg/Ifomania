<div id="screen-otzivi">
	<div class="container">
		<div class="row">
			<div class="col-xs-8 col-xs-offset-2">
				<br />
				<h2 class="text-center text-uppercase">Ты еще сомневаешься?</h2>
				<div class="text-muted text-center text-uppercase"><font size="+1">Свежие отзывы наших участников</font></div>
				<br />
				<br />
				<? if(!empty($comments)): ?>
					<div class="slick">
						<? foreach($comments as $comment): ?>
							<div>
								<div class="comment-item">
									<div class="comment-item-user">
										<div class="comment-item-avatar">
											<? if(!empty($comment->avatar)): ?>
												<img class="img-circle" width="180" height="180" src="/uploads/<?= $comment->avatar ?>" />
											<? else: ?>
												<img class="img-circle" width="180" height="180" src="/img/avatar_empty_man.jpg" />
											<? endif; ?>
										</div>
										<div class="comment-item-fio text-eclipse">
											<?= $comment->fio ?>
										</div>
									</div>
									<div class="comment-item-field">
										<div class="dialog">
											<?= $comment->text ?>
										</div>
									</div>
								</div>
							</div>
						<? endforeach; ?>
					</div>	
				<? endif; ?>
				<br />
				<br />
				<br />
			</div>
		</div>
	</div>
</div>
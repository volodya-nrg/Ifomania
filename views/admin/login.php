<br />
<br />
<br />
<div class="col-xs-4 col-xs-offset-4">
	<table class="table table-bordered">
		<tr>
			<td>
				<form role="form" action="" method="post">
					<? if(Yii::$app->session->hasFlash('error')): ?>
						<div class="alert alert-danger">
							<ul>
								<? foreach(Yii::$app->session->getFlash('error') as $val): ?>
									<li><?= $val ?></li>
								<? endforeach; ?>
							</ul>
						</div>
					<? endif; ?>
					
					<div class="form-group">
						<label>Логин</label>
						<input type="text" class="form-control" name="login" />
					</div>
					<div class="form-group">
						<label>Пароль</label>
						<input type="password" class="form-control" name="pass" />
					</div>
					<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
					<button type="submit" class="btn btn-primary">Отправить</button>
				</form>	
			</td>
		</tr>
	</table>
</div>

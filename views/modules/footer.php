<?
use yii\helpers\Url;
?>
<div id="screen-footer">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 text-center">
				<br />
				<br />
				<div>
					<div class="footer-item-with-img">
						<div class="footer-item-with-img-cover">
							<img height="90" src="/img/dogovor.png" />
						</div>
						<a class="a-pink text-uppercase" href="<?= Url::to(['/page/dogovor-oferty']) ?>">Договор оферты</a>
					</div>
					<div class="footer-item-with-img">
						<div class="footer-item-with-img-cover">
							<img height="90" src="/img/doc.png" />
						</div>
						<a class="a-pink text-uppercase" href="<?= Url::to(['/page/ob-aktsii']) ?>">Правила акции</a>
					</div>
				</div>
				<div>
					<br />
					<br />
					<div class="h4 text-white text-uppercase">Способы оплаты</div>
					<br />
					<img height="50" src="/img/icon_visa.png" />
					<img height="50" src="/img/icon_mastercard.png" />
					<img height="50" src="/img/icon_sber.png" />
					<img height="50" src="/img/icon_alfa.png" />
					<img height="50" src="/img/icon_tinkof.png" />
				</div>
				<br />
				<br />
			</div>
		</div>
	</div>	
</div>
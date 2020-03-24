<?
use yii\helpers\Url;
?>
<div id="screen-lk">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2">
				<br />
				<h2 class="text-center text-uppercase">Личный кабинет</h2>
				<table align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center" valign="middle">
							<img id="screen-lk-monitor" width="500" src="/img/comp.jpg" />
						</td>
						<td width="30"></td>
						<td align="left" valign="middle" width="250">
							<p class="text-muted"><i>We currently hold one of the most innovative and modern product lines in the world. Trading for 10 years we have grown within the market, to bring the newest products available.</i></p>									
							<p class="text-muted"><i>All of our products are printed with a “QR Code” on the box, bling us to ensure all logistic needs are met. </i></p>
							<br />
							<center>
								<button class="btn btn-gradient btn-lg btn-block" 
										data-toggle="modal" 
										data-target="#pop-up-participate">Принять участие</button>
								<br />
								<a class="a-vinous" href="<?= Url::to(['/page/ob-aktsii']) ?>"><i>Подробнее об акции</i></a>
							</center>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br />
		<br />
	</div>
</div>
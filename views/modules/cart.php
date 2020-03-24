<?
use yii\helpers\Url;
use yii\helpers\MyCustom;
?>
<div id="screen-cart">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<h3 class="text-uppercase">Ваша корзина</h3>
				<br />
				<? if(!empty($products)): ?>
					<table class="tbl-cart" border="0" cellspacing="0" cellpading="0" width="100%">
						<thead height="50">
							<tr>
								<th class="hidden-xs" width="140"></th>
								<th class="hidden-xs" width="20"></th>	
								<th>
									<div class="text-darkblue"><i>Наименование</i></div>
								</th>
								<th width="20"></th>
								<th width="150">
									<div class="text-center text-darkblue"><i>Цена за одну штуку</i></div>
								</th>
								<th width="20"></th>
								<th align="center" width="150"></th>
								<th width="20"></th>
								<th width="150">
									<div class="text-center text-darkblue"><i>Сумма</i></div>
								</th>
								<th width="20"></th>
								<th width="40"></th>
							</tr>	
						</thead>
						<tbody>
							<? foreach($products as $product): ?>
								<tr>
									<td class="hidden-xs" align="left" valign="middle">
										<a href="/<?= $product['data']->slug ?>">
											<div class="img-wrapper img-wrapper-md">
												<? if(!empty($product['data']->is_sale)): ?>
													<div class="circle-gradient circle-gradient-sm">акция</div>
												<? endif; ?>

												<? if(!empty($product['data']->imageFiles[0])): ?>
													<img src="/uploads/thumb_<?= $product['data']->imageFiles[0]->name ?>" />
												<? else: ?>
													<img src="/img/cover_empty.jpg" />
												<? endif; ?>
											</div>
										</a>	
									</td>
									<td class="hidden-xs"></td>	
									<td align="left" valign="middle">
										<? if(!empty($product['data']->is_sale)): ?>
											<div class="circle-gradient circle-gradient-sm visible-xs">акция</div><br />
										<? endif; ?>
										<a class="text-uppercase" href="/<?= $product['data']->slug ?>"><?= $product['data']->name ?></a>
									</td>
									<td></td>
									<td align="center" valign="middle">
										<span class="text-uppercase"><?= MyCustom::htmlPrice($product['data']->price) ?> руб.</span>
									</td>
									<td></td>
									<td align="center" valign="middle">
										<div class="input-group">
											<span class="input-group-btn">
												<button class="btn btn-default btn-minus" type="button" onclick="plusMinusAmountOnCart(this)"><i class="fa fa-minus text-pink"></i></button>
											</span>
											<input type="text" class="form-control text-center" maxlength="3" value="<?= $product['total'] ?>" onchange="updateAmountCart(this, <?= $product['data']->id ?>)" >
											<span class="input-group-btn">
												<button class="btn btn-default btn-plus" type="button" onclick="plusMinusAmountOnCart(this)"><i class="fa fa-plus"></i></button>
											</span>	
										</div>
									</td>
									<td></td>	
									<td align="center" valign="middle">
										<span class="tbl-cart-row-price" class="text-uppercase"><?= MyCustom::htmlPrice($product['data']->price * $product['total']) ?></span> <span class="text-uppercase">руб.</span>
									</td>
									<td></td>	
									<td align="center" valign="middle">
										<button class="btn btn-remove-product" onclick="removeFromCart(this, <?= $product['data']->id ?>)"><i class="fa fa-times-circle-o fa-2x text-pink"></i></button>
									</td>	
								</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				<? endif; ?>
				<br />
				<div id="message-cart-empty" class="text-center text-muted <?= !empty($products)? 'hide': '' ?> "><font size="+1">корзина пуста</font></div>
			</div>
		</div>
	</div>
</div>
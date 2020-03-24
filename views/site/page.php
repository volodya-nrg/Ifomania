<?
	$path = __DIR__.'/../modules';
	$this->title = $Page->title;
	$this->registerMetaTag(['name' => 'description', 'content' => $Page->meta_desc]);
	$this->registerMetaTag(['name' => 'keywords', 'content' => $Page->meta_keywords]);
?>

<? include($path.'/index_slim.php') ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1><?= $Page->h1 ?></h1>
			<?= $Page->text ?>
			<br />
		</div>
	</div>
</div>

<? include($path.'/footer.php') ?>
<? include($path.'/pop_ups.php') ?>
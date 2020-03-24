<?
use yii\helpers\Url;

$link = Url::to(['confirm-email', 'secret' => $secret], true);
?>
<h1>Подтверждение эл. почты</h1>
<hr />
Здравствуйте <?= $fio ?>, подтвердите пожалуйста свой e-mail, перейдя по ссылке ниже.
<br />
<a href="<?= $link ?>" target="_blank"><?= $link ?></a>
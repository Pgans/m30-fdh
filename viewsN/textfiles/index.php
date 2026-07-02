<?php
use yii\helpers\Url;
?>

<h1>Export 16 แฟ้ม</h1>

<p>กรุณาคลิกปุ่ม Export: </p>

<a href="<?= Url::to(['textfiles/adp']) ?>" class="btn btn-primary">ADP</a> 
<a href="<?= Url::to(['textfiles/cha']) ?>" class="btn btn-primary">CHA</a> 
<a href="<?= Url::to(['textfiles/cht']) ?>" class="btn btn-primary">CHT</a> 
<a href="<?= Url::to(['textfiles/ins']) ?>" class="btn btn-primary">INS</a> 
<a href="<?= Url::to(['textfiles/dru']) ?>" class="btn btn-primary">DRU</a> 
<a href="<?= Url::to(['textfiles/labfu']) ?>" class="btn btn-primary">LABFU</a>
<a href="<?= Url::to(['textfiles/opx']) ?>" class="btn btn-primary">ODX</a> 
<a href="<?= Url::to(['textfiles/oop']) ?>" class="btn btn-primary">OOP</a> 
<a href="<?= Url::to(['textfiles/opd']) ?>" class="btn btn-primary">OPD</a> 
<a href="<?= Url::to(['textfiles/exporttext']) ?>" class="btn btn-primary">PAT</a> 


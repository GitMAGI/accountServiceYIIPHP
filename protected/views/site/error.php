<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->pageTitle = $data['pageTitle'];
$pageSubTitle = $data['pageSubTitle'];

?>

<section class="content-header">
<h1><?php echo $this->pageTitle;?> <small><?php echo $pageSubTitle;?></small></h1>

<?php
    //$this->renderPartial('//widget/breadcrumb', array('bcs'=>$data['breadcrumb']));	
?>
</section>

<section class="content">	
	<div class="row">
            <div class="col-md-12">
                <?= nl2br(Html::encode($message)) ?>
            </div>
	</div>
	<div class="row">
		<p>The above error occurred while the Web server was processing your request.</p>
		<p>Please contact us if you think this is a server error. Thank you.</p>
	</div>
</section>


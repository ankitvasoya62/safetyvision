<?php
/* @var $this ConvertController */
/* @var $data Convert */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('token')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->token), array('view', 'id'=>$data->token)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />


</div>
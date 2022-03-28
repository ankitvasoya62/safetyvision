<?php
/* @var $this ConvertController */
/* @var $model Convert */

$this->breadcrumbs=array(
	'Converts'=>array('index'),
	$model->token,
);

$this->menu=array(
	array('label'=>'List Convert', 'url'=>array('index')),
	array('label'=>'Create Convert', 'url'=>array('create')),
	array('label'=>'Update Convert', 'url'=>array('update', 'id'=>$model->token)),
	array('label'=>'Delete Convert', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->token),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Convert', 'url'=>array('admin')),
);
?>

<h1>View Convert #<?php echo $model->token; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'token',
		'params',
	),
)); ?>

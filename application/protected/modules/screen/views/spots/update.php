<?php
/* @var $this SpotsController */
/* @var $model Spots */

$this->breadcrumbs=array(
	'Spots'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Spots', 'url'=>array('index')),
	array('label'=>'Create Spots', 'url'=>array('create')),
	array('label'=>'View Spots', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Spots', 'url'=>array('admin')),
);
?>

<h1>Update Spots <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
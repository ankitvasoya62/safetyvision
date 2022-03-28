<?php
/* @var $this ConvertController */
/* @var $model Convert */

$this->breadcrumbs=array(
	'Converts'=>array('index'),
	$model->token=>array('view','id'=>$model->token),
	'Update',
);

$this->menu=array(
	array('label'=>'List Convert', 'url'=>array('index')),
	array('label'=>'Create Convert', 'url'=>array('create')),
	array('label'=>'View Convert', 'url'=>array('view', 'id'=>$model->token)),
	array('label'=>'Manage Convert', 'url'=>array('admin')),
);
?>

<h1>Update Convert <?php echo $model->token; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
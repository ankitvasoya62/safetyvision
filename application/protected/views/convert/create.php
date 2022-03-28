<?php
/* @var $this ConvertController */
/* @var $model Convert */

$this->breadcrumbs=array(
	'Converts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Convert', 'url'=>array('index')),
	array('label'=>'Manage Convert', 'url'=>array('admin')),
);
?>

<h1>Create Convert</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this SpotsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spots',
);

$this->menu=array(
	array('label'=>'Create Spots', 'url'=>array('create')),
	array('label'=>'Manage Spots', 'url'=>array('admin')),
);
?>

<h1>Spots</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

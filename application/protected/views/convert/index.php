<?php
/* @var $this ConvertController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Converts',
);

$this->menu=array(
	array('label'=>'Create Convert', 'url'=>array('create')),
	array('label'=>'Manage Convert', 'url'=>array('admin')),
);
?>

<h1>Converts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

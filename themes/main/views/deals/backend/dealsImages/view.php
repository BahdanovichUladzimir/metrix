<?php

/**
 * @var $model DealsImages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals images')=>array('index'),
	$model->url,
);

?>

<h1><?=Yii::t("dealsModule","View deal image");?> <small><?php echo $model->url; ?></small></h1>
<h4><?=Yii::t("dealsModule","Small thumb");?></h4>
<p>
	<?=CHtml::image($model->getSmallThumbUrl());?>
</p>
<h4><?=Yii::t("dealsModule","Medium thumb");?></h4>
<p>
	<?=CHtml::image($model->getMediumThumbUrl());?>
</p>
<h4><?=Yii::t("dealsModule","Large thumb");?></h4>
<p>
	<?=CHtml::image($model->getLargeThumbUrl());?>
</p>
<h4><?=Yii::t("dealsModule","Original image");?></h4>
<p>
	<?=CHtml::image($model->getImageUrl());?>
</p>
<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'file_name',
		'ext',
		'path',
		'dir_path',
		'dir_url',
		'url',
		'width',
		'height',
		'deal_id',
		'approve',
),
)); ?>

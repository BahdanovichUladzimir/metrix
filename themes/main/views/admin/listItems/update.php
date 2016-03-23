<?php

/**
 * @var $model ListItems
 * @var array $listsListData
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','List items')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('adminModule','Update list item');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'listsListData' => $listsListData
    )
); ?>
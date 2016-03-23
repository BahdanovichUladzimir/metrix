<?php

/**
 * @var $model ListItems
 * @var array $listsListData
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','List items')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('adminModule', 'Create list item');?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'listsListData' => $listsListData,
    )
); ?>
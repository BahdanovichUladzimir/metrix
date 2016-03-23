<?php
$this->breadcrumbs=array(
	'Yiiseo Urls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);?>

<h1><?=Yii::t('yiiseoModule','Update yiiseo url')?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array( 'model'=>$model,
                                                'modelTitle'=>$modelTitle,
                                                "modelKeywords"=>$modelKeywords,
                                                "modelDescription"=>$modelDescription,
                                                "modelOther"=>$modelOther,)); ?>
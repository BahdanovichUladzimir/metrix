<?php

/**
 * @var $model Deals
 * @var $paramsModel DealCategoriesParams
 * @var array $statusesList
 * @var array $categoriesList
 * @var array $approveList
 * @var array $priorityList
 * @var array $usersList
 * @var array $citiesList
 * @var array $archiveList
 * @var array $currenciesList
 * @var $imagesModel XUploadForm
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('dealsModule','Update'),
);

	?>

	<h1><small><?=Yii::t('dealsModule','Update deal');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'categoriesList' => $categoriesList,
		'statusesList' => $statusesList,
		'approveList' => $approveList,
		'priorityList' => $priorityList,
		'archiveList' => $archiveList,
		'paramsModel'=> $paramsModel,
		'usersList'=> $usersList,
        'citiesList'=> $citiesList,
        'currenciesList'=> $currenciesList,
        'imagesModel' => $imagesModel,
	)
); ?>
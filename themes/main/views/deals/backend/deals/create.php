<?php

/**
 * @var $model Deals
 * @var array $statusesList
 * @var array $categoriesList
 * @var array $approveList
 * @var array $priorityList
 * @var array $archiveList
 * @var array $usersList
 * @var array $citiesList
 * @var array $currenciesList
 * @var $paramsModel DealCategoriesParams
 * @var $imagesModel XUploadForm
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals'=>array('index'),
	Yii::t('dealsModule','Create'),
);

?>

<h1><?=Yii::t('dealsModule','Create deal');?></h1>

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
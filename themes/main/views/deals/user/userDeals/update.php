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
 * @var array $postData
 */
$this->breadcrumbs=array(
	//Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	//Yii::t('dealsModule','My deals')=>array('index'),
	Yii::t('userModule','Profile')=>$model->user->getPrivateUrl(),
	' '.$model->name => $model->getPublicUrl(),
	Yii::t('dealsModule','Update'),
);?>

	<h1><small><?=Yii::t('dealsModule','Update Deal');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'statusesList' => $statusesList,
		'approveList' => $approveList,
		'priorityList' => $priorityList,
		'archiveList' => $archiveList,
		'paramsModel'=> $paramsModel,
		'usersList'=> $usersList,
        'citiesList'=> $citiesList,
        'currenciesList'=> $currenciesList,
        'imagesModel' => $imagesModel,
		'postData' => $postData,
	)
); ?>
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
 * @var $user User
 * @var array $postData
 */
$this->breadcrumbs=array(
	Yii::t('userModule','Profile')=>$user->getPublicUrl(),
	Yii::t('core','Create deal'),
);

?>

<h1 class="title section-title"><?=Yii::t('dealsModule','Create deal');?></h1>
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
        'user' => $user,
		'postData' => $postData,
	)
); ?>
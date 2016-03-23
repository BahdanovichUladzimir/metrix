<?php

/**
 * @var $model Feedback
 * @var array $categoriesList
 * @var $user User
 * @var bool $showFormLabel
 */
$this->breadcrumbs=array(
	//Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    //Yii::t('feedbackModule', 'Feedback')=>array('index'),
	Yii::t('feedbackModule', 'Feedback'),
);

?>

<h1><?=Yii::t('feedbackModule', 'Create Feedback');?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'user' => $user,
        'showFormLabel' => $showFormLabel,
    )
); ?>
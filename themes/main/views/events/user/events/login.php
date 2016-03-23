<?php
/**
 * @var $model Events
 * @var $form TbActiveForm
 * @var $loginModel EventLogin
 */
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('userModule',"Login");
$this->breadcrumbs=array(
	Yii::t('userModule',"Event login"),
);
?>
<?php if( Yii::app()->user->hasFlash('eventLogin')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('eventLogin'); ?>
	</div>
<?php endif; ?>
<div class="col-md-4 col-lg-4 col-sm-3">

</div>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
	<h1><?php echo Yii::t('userModule',"Event login"); ?></h1>


	<p><?php echo Yii::t('userModule',"Please fill out the following form with your login credentials:"); ?></p>

	<?php $form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'login_form',
			//'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			//'type' => 'horizontal',
			'htmlOptions' => array('class' => 'well'), // for inset effect
			'clientOptions'=>array(
				'successCssClass'=> 'has-success',
				'errorCssClass'=> 'has-error',
				//'validateOnSubmit'=>true,
				//'validationUrl'=>Yii::app()->createUrl('/user/login/validate'),
			),
			'errorMessageCssClass' => 'text-danger small',
		)
	);?>
	<?=$model->login;?>

	<?php echo $form->passwordFieldGroup(
        $loginModel,
		'password'
	); ?>

	<?php $this->widget('booster.widgets.TbButton',
		array(
			'buttonType' => 'submit',
			'context' => 'success',
			'label' => Yii::t('userModule',"Login")
		)
	);?>
	<?php $this->endWidget();?>
	<?php unset($form);?>

</div>
<div class="col-md-4 col-lg-4 col-sm-3">

</div>


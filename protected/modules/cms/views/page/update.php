<?php
/**
 * @var $model CmsPage
 * @var $this PageController
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Page')=>array('index'),
    Yii::t('adminModule','Update'),
);
?>
<h1><?php echo 'Редактирование страницы'; ?></h1>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm');
?>

<?php
$this->widget('booster.widgets.TbTabs', array(
    'tabs' => $this->getFormTabs($form, $model),
        //'htmlOptions'=>array('class'=>'cms-form-tabs'),
));
?>

<?php $this->renderPartial('cms.views.node._formActions', array('model' => $model)); ?>

<?php $this->endWidget(); ?>

<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php
/**
 * @var \$model $this->modelClass
 * @var \$form TbActiveForm
*/
;?>\n"
;?>
<?php echo "<?php \$form=\$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>\n"; ?>

<p class="help-block"><?php echo '<?=Yii::t("core","Fields with <span class=\'required\'>*</span> are required.");?>';?></p>

<?php
foreach ($this->tableSchema->columns as $column) {
	if ($column->autoIncrement){
		continue;
	}
	?>
	<?php echo "<?php echo " . $this->generateActiveGroup($this->modelClass, $column) . "; ?>\n"; ?>

<?php
}
?>
<div class="form-actions">
	<?php echo "<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>";?>
	<?php echo "<?php \$this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'reset',
			'context'=>'danger',
			'label'=>Yii::t('core','Reset'),
		)); ?>\n"; ?>
	<?php echo "<?php \$this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>\$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
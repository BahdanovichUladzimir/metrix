<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n
/**
 * @var \$model $this->modelClass
 */
";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'$label'=>array('index'),
	Yii::t('core', 'Create'),
);\n";
?>

?>

<h1><?php echo "<?=Yii::t('$this->modelClass', 'Create ".$this->modelClass."');?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

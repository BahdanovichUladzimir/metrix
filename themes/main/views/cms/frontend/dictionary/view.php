<?php

/**
 * @var $model Dictionary
 * @var array $rusAlphabet
 * @var array $enAlphabet
 */
$this->breadcrumbs=array(
	Yii::t('cmsModule','Dictionary')
);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1><?=Yii::t('Dictionary','Dictionary');?></h1>
        <?php foreach($rusAlphabet as $rusLetter):?>
            <?php if($model->letter == $rusLetter):?>
                <span class="dictionary-menu-letter active"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></span>
            <?php else:?>
                <span class="dictionary-menu-letter"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></span>
            <?php endif;?>
        <?php endforeach;?>
        <?php if(in_array($model->letter,$enAlphabet)):?>
            <span class="dictionary-menu-letter active"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></span>
        <?php else:?>
            <span class="dictionary-menu-letter"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></span>
        <?php endif;?>
        <span class="dictionary-menu-letter"><?=CHtml::link(Yii::t('cmsModule','All'),Yii::app()->createUrl("/cms/frontend/dictionary/index"));?></span>
        <h2 class="dictionary-letter"><?=$model->name;?></h2>
        <p><?=$model->description;?></p>
        <hr class="dictionary-hr">
        <h2><?=Yii::t('cmsModule','Articles containing the definition:');?></h2>
        <ul class="list-unstyled">
            <?php foreach($model->cmsPage as $page):?>
                <li><?php echo CHtml::link(CHtml::encode($page->content->heading), Yii::app()->cms->createUrl($page->name)); ?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

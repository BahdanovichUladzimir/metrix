<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.07.2015
 * @var array $categoriesList
 * @var $model Deals
 */
if($model->hasErrors('categories')){
    $errorsString = implode(' ',$model->getErrors('categories'));
}
;?>
<div class="select-wrap">
    <div class="form-group <?=($model->hasErrors('categories')) ? 'has-error':'';?>">
        <select name="deals_categories" class="categories-select">
            <option value=""><?=Yii::t('dealsModule','Select category');?></option>
            <?php foreach($categoriesList as $id=>$name):?>
                <option value="<?=$id;?>" <?=(isset($model->categories) && sizeof($model->categories)>0 && $model->categories[0]->id == $id) ? 'selected="selected"': '';?>><?=$name;?></option>
            <?php endforeach;?>
        </select>
        <div class="subcats">

        </div>
        <div class="help-block error categories-select-help-block" <?=($model->hasErrors('categories')) ? 'style="display:block;"':'';?>><?=($model->hasErrors('categories')) ? $errorsString:'';?></div>

    </div>
</div>



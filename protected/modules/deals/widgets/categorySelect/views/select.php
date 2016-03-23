<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.07.2015
 * @var array $categoriesList
 * @var $model Deals
 * @var $category DealsCategories
 * @var string $childrenSelect
 */
;?>
<div class="select-wrap">
    <div class="form-group">
        <select name="deals_categories" class="categories-select">
            <option value=""><?=Yii::t('dealsModule','Select category');?></option>
            <?php foreach($categoriesList as $id=>$name):?>
                <option value="<?=$id;?>" <?=(!is_null($category) && $category->id == $id) ? 'selected="selected"': '';?>><?=$name;?></option>
            <?php endforeach;?>
        </select>
        <div class="subcats">
            <?=$childrenSelect;?>
        </div>
    </div>
</div>
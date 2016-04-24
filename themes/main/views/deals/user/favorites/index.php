<?php
/**
 * @var $this CatalogController
 * @var $dataProvider CActiveDataProvider
 * @var $category DealsCategories
 * @var $model Deals
 */
?>
<div class="row">
    <section class="col-lg-9">
        <div class="cf">
            <?php /*$this->widget('widgets.currencySelect.CurrencySelectWidget');*/?>
            <h1 class="title section-title h1"><?=$this->h1;?></h1>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$model->search(),
            'itemView'=>'_deal',   // refers to the partial view named '_post'
            /*'sortableAttributes'=>array(
                'name',
            ),*/
            'template' => '{pager}{items}{pager}',
            'summaryText' => '',
            // 'ajaxUpdate' => false,
            //class="pagination pagination-centered"
            'pagerCssClass' => 'pagerCssClass',
            'pager' => array(
                'maxButtonCount' => 12,
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'footer' => '</nav>',
                'header' => '<nav>',
                'selectedPageCssClass' => 'active',
                'htmlOptions' => array(
                    'class' => 'pagination'
                )
            ),
            'id' => 'my_favorites_list'

            //array()
        ));?>

    </section>
    <!--<aside class="col-lg-3">
        <h2 class="title section-title h2">Фильтр</h2>
        <div class="panel">
            <div class="panel-body filter-form">
                <form>
                    <div class="form-group">
                        <label>Местоположение</label>
                        <select>
                            <option>Москва</option>
                            <option>Санкт-петербург</option>
                            <option>Нижний новгород</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Сортировать по:</label>
                        <select>
                            <option>Популярности</option>
                            <option>По цене</option>
                        </select>
                    </div>
                    <div class="price-choice cf">
                        <div>
                            <span>от</span>
                            <input type="text" />
                        </div>
                        <div>
                            <span>до</span>
                            <input type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="checkbox"><input type="checkbox" /><span class="a-spr"></span> Агенства</label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox"><input type="checkbox" /><span class="a-spr"></span> Частные лица</label>
                    </div>
                    <input type="submit" class="btn btn-big btn-success" value="Найти" />
                </form>
            </div>
        </div>
    </aside>-->
</div>


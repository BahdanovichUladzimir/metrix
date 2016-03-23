<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var int $widgetId
 * @var $model UserLogin
 * @var $form TbActiveForm
 */
;?>
<?php
$this->widget('zii.widgets.CMenu', array(
    'items'=>array(
        array(
            'url'=>Yii::app()->createUrl('/deals/user/userDeals/create'),
            'label'=>Yii::t("dealsModule","Add deal"),
            //'visible'=>Yii::app()->user->isGuest,
            'linkOptions'=>array(
                'class'=>'btn btn-blue',
            ),
        ),

    ),
    'htmlOptions' => array(
        'class' => 'login nav navbar-nav navbar-right',
        'id' => "authenticateWidget_".$widgetId
    )
));
;?>
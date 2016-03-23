<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 09.07.2015
 * @var string $appId
 * @var string $containerId
 * @var string $scope
 * @var string $redirectUri
 * @var string $display
 * @var string $apiVersion
 * @var string $responseType
 */
;?>
<?php Yii::app()->clientScript->registerScriptFile('//vk.com/js/api/openapi.js?116', CClientScript::POS_END);?>
<?php $script = "VK.init({apiId: ".$appId."});";?>
<?php Yii::app()->clientScript->registerScript('vk_api', $script, CClientScript::POS_END);?>

<?=CHtml::link(
    Yii::t('userModule',"Login with Vkontakte"),
    'https://oauth.vk.com/authorize?client_id='.$appId.'&scope='.$scope.'&redirect_uri='.$redirectUri.'&display='.$display.'&v='.$apiVersion.'&response_type='.$responseType,
    array('class' => 'btn btn-big btn-vk b')
);?>

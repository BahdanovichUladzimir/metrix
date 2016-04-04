<?php
/**
 * @var $this FrontendController
 * @var string $content
 */
?>

<?php $moduleId = (!is_null(Yii::app()->controller->module)) ? Yii::app()->controller->module->getId() : '';?>
<?php $controllerId = Yii::app()->controller->getId();?>
<?php $actionId = Yii::app()->controller->action->getId();?>


<!DOCTYPE html>
<html lang="ru">

<?php $this->renderPartial("//layouts/partials/_frontend_head");?>

<body>
<div class="page cf <?=Yii::app()->user->isGuest ? '' : $this->pageClass;?>">
    <?php $this->renderPartial(
        '//layouts/partials/_frontend_header_new',
        array(
            'moduleId' => $moduleId,
            'controllerId' => $controllerId,
            'actionId' => $actionId
        )
    );?>
    <section>
        <?php /**  if(Yii::app()->request->requestUri == '/'):?>
            <div class="banner-container">
                <div class="banner-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-7 hidden-xs">
                                <div class="instead-of-content"></div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="height90-block hidden-xs">

                                </div>
                                <div class="competition-text-container">
                                    <h2 class="competition-title">ALL4HOLIDAYS
                                        <br>
                                        <span class="gold">КОНКУРС</span>
                                    </h2>
                                    <span class="gold competition-title-note">Выиграй ценные подарки</span>
                                    <ul class="competition-tasks-list list-unstyled">
                                        <li><a href="<?=Yii::app()->createUrl('/user/registration/authorization');?>">Присоединяйся к all4holidays</a></li>
                                        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/create');?>">Добавляй объявления</a></li>
                                        <?php if(Yii::app()->user->isGuest):?>
                                            <li><a href="<?=Yii::app()->createUrl('/user/registration/authorization');?>">Приглашай друзей</a></li>
                                        <?php else:?>
                                            <?php
                                                $url = Yii::app()->createAbsoluteUrl("user/registration/authorization?invite_code=".User::model()->findByPk(Yii::app()->user->getId())->invitekey);
                                                $title = Yii::t('userModule',"all4holidays.com - all for holidays");
                                                $description = Yii::t('userModule',"Join me on all4holidays.com");
                                                $image = Yii::app()->createAbsoluteUrl('images/logo.png')
                                            ;?>
                                            <li>
                                                <a href="http://vk.com/share.php?url=<?=$url;?>&title=<?=$title;?>&description=<?=$description;?>&image=<?=$image;?>" target="_blank">
                                                    Приглашай друзей
                                                </a>
                                            </li>
                                        <?php endif;?>
                                    </ul>
                                    <a href="https://all4holidays.com/konkurs-23.html" class="competition-read-more-link">Узнать больше <span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;**/?>
        <div class="container">
            <?php // Не кэшируем хлебные крошки так как кэшируется ссылка на кабинет пользователя;?>
            <?php /*if($this->beginCache('breadcrumbs_'.$this->userCityId.'_'.Yii::app()->language."_".Yii::app()->request->url, array('duration' => 60*60*24))):*/?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                    'tagName' => "ol",
                    'separator' => " ",
                    'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>',
                    'inactiveLinkTemplate'=>'<li class="active">{label}</li>',
                    'htmlOptions' => array(
                        'class' => 'breadcrumb',
                        'id' => 'breadcrumbs'
                    )
                ));
                ;?>
                <?php /*$this->endCache();*/?><!--
            --><?php /*endif;*/?>
            <?php echo $content;?>
        </div>
    </section>
</div>
<?php $this->renderPartial('//layouts/partials/_frontend_footer');?>

<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap.min.js', CClientScript::POS_HEAD);?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-noconflict.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootbox.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/notify.min.js', CClientScript::POS_END);?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-select.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-cookie/src/jquery.cookie.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/scripts.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/uppod-0.5.26.js', CClientScript::POS_END);?>
<?php if(Yii::app()->user->checkAccess('Translate.Translate.Update') && Yii::app()->user->checkAccess('Translate.Translate.Create')):?>
    <?php Yii::app()->translate->renderMissingTranslationsEditor();?>
<?php endif;?>



<a class="scroll-top"></a>

</body>

</html>

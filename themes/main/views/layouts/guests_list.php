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
<script>
    $(document).ready(function(){
        $.stellar({
            hideDistantElements: false,
            positionProperty: 'transform',
            horizontalScrolling: false,
            responsive: true
        });

        function is_touch_device() {
            return !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
        };
        if (is_touch_device()) {
            $('.prlx').removeAttr('data-stellar-ratio');
            $.stellar({
                hideDistantElements: false,
                positionProperty: 'transform',
                horizontalScrolling: false,
                responsive: false
            });
        }
    });
</script>
<div class="page cf <?=Yii::app()->user->isGuest ? '' : "user-page";?>">
    <?php $this->renderPartial(
        '//layouts/partials/_frontend_header_new',
        array(
            'moduleId' => $moduleId,
            'controllerId' => $controllerId,
            'actionId' => $actionId
        )
    );?>
    <section>
        <div class="head-big">
            <img src="<?=$this->bgImage;?>" alt="" class="prlx" data-stellar-ratio="0.5" />
            <div class="main-title-wrap">
                <div class="container ta-l">
                    <?php /*if($this->beginCache('breadcrumbs_'.$this->userCityId.'_'.Yii::app()->language, array('duration' => 60*60*24))):*/?>
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
                    <div class="main-txt min">
                        <span class="title"><?=$this->pageTitle;?></span>
                        <?=$this->pageDescription;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="reg">
            <div class="container">

                <?php echo $content;?>
            </div>
        </div>
    </section>
</div>
<?php $this->renderPartial('//layouts/partials/_frontend_footer');?>
<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-noconflict.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootbox.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/notify.min.js', CClientScript::POS_END);?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-select.min.js', CClientScript::POS_END);?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jscrollpane.min.js');?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.mousewheel.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-cookie/src/jquery.cookie.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.stellar.min.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/smooth-scroll.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/scripts.js', CClientScript::POS_END);?>
<?php /*if(Yii::app()->user->checkAccess('Translate.Translate.Update') && Yii::app()->user->checkAccess('Translate.Translate.Create')):*/?><!--
    <?php /*Yii::app()->translate->renderMissingTranslationsEditor();*/?>
--><?php /*endif;*/?>



<a class="scroll-top"></a>

</body>
</html>

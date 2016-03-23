<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 16.03.2015
 * @var $this FrontendController
 */
;?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <?php if (!is_null($this->title)): ?>
        <title><?php echo $this->title; ?></title>
        <meta name="description" content="<?= (is_null($this->description)) ? '' : $this->description; ?>">
        <meta name="revisit-after" content="7 days">
        <meta name="keywords" lang="<?=Yii::app()->language;?>" content="<?=(is_null($this->keywords)) ? '' : $this->keywords;?>">
    <?php else:?>
        <?php if($this->beginCache('seo'. Yii::app()->language . Yii::app()->request->url, array('duration' => 3600))):?>
            <?php Yii::app()->seo->run(Yii::app()->language);?>
            <?php $this->endCache();?>
        <?php endif;?>
    <?php endif;?>

    <?php Yii::app()->clientScript->registerCssFile("https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600&subset=latin,cyrillic-ext,cyrillic");?>
    <?php Yii::app()->clientScript->registerCssFile("https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&subset=latin,cyrillic-ext,cyrillic");?>
    <?php Yii::app()->clientScript->registerCssFile("https://fonts.googleapis.com/css?family=Roboto:400,500,700&subset=latin,cyrillic-ext,cyrillic");?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/reset.css');?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap.min.css');?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-select.min.css');?>
    <?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');?>
    <?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.jscrollpane.css');?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/stl.css');?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css');?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/cross.css');?>
    <script>
        window.translation = $.parseJSON('<?=CJSON::encode($this->translation);?>');
        function translate(category, message){
            if(window.translation !== "undefined" && window.translation.length>0){
                for(var i=0;i<window.translation.length;i++){
                    var translate = window.translation[i];
                    if(translate.category === category && translate.message === message){
                        return translate.translation;
                    }
                }
            }
            return message;
        }
    </script>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <!--[if lte IE 7]><script src="http://phpbbex.com/oldies/oldies.js" charset="utf-8"></script><![endif]-->

    <?php Yii::app()->clientScript->registerScript('bootstrap-noconflict','
        var bootstrapButton, bootstrapTooltip;

        (function ($) {
            bootstrapButton = $.fn.button;
            bootstrapTooltip = $.fn.tooltip;
        })(jQuery);
        ',
        CClientScript::POS_HEAD
    );?>
</head>


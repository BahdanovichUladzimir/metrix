<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.11.2015
 */
;?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,700italic,400italic&subset=latin,greek,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href="/css/reset.css" rel="stylesheet"/>
    <link href="/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/bootstrap-select.min.css" rel="stylesheet"/>
    <link href="/css/stl.css" rel="stylesheet"/>
    <link href="/css/cross.css" rel="stylesheet"/>
    <!--[if IE]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 7]><script src="https://phpbbex.com/oldies/oldies.js" charset="utf-8"></script><![endif]-->
</head>
<body>
    <h1><?=Yii::t('dealsModule',"You are over 16 years old?");?></h1>
    <p><?=Yii::t("dealsModule","This page is intended for viewing to persons who have reached the age of majority.");?></p>
    <p><?=Yii::t("dealsModule","You already have 16 years?");?></p>
    <p>
        <?=CHtml::link(Yii::t("dealsModule","Yes"),"", array('id' => 'proof_of_age_confirmation_link_yes', "class" => "btn btn-success"));?>
        <?=CHtml::link(Yii::t("dealsModule","No"),"", array('id' => 'proof_of_age_confirmation_link_no', "class" => "btn btn-danger"));?>
    </p>

<!--<script src="/js/jquery-1.10.2.min.js"></script>-->
<!--<script src="/js/bootstrap.min.js"></script>
<script src="/js/scripts.js"></script>-->



</body>
</html>



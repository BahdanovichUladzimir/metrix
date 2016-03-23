<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 04.02.2016
 * @var $deal Deals
 * @var array $phones
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
<h5><?=Yii::t('dealsModule',"Deal contacts");?>:</h5>
<?php foreach ($phones as $phone):?>
    <p>
        <?=$phone['param']->label;?>: <strong><?=DealCategoriesParams::getPublicPhoneNumber($phone['paramValue']->value);?></strong>
    </p>
<?php endforeach;?>
<?php if(!is_null($deal->user->profile->email) && strlen(trim($deal->user->profile->email))>0):?>
    <p><?=Yii::t('dealsModule',"Email");?>: <a href="mailto:<?=$deal->user->profile->email;?>"><?=$deal->user->profile->email;?></a></p>
<?php endif;?>
<p><strong><?=Yii::t('dealsModule',"Do not forget to say that you have found this ad at the website all4holidais.com");?></strong></p>
<h5><?=Yii::t('dealsModule',"Please rate the quality of contact information");?>:</h5>
<?=CHtml::beginForm(Yii::app()->createUrl('/deals/frontend/catalog/setContactsQuality'),'POST', array('class' => 'form','id' => 'setDealContactsQualityForm'));?>
<?php $counter = 1;?>
<?php foreach(Deals::$dealsContactsQualities as $k => $quality):?>
    <?php if($counter == 1):?>
        <?=CHtml::radioButton('quality', false, array('id' =>'quality_'.$k, 'checked' => 'checked'));?>
    <?php else:?>
        <?=CHtml::radioButton('quality', false, array('id' =>'quality_'.$k));?>
    <?php endif;?>
    <?=CHtml::label($quality, 'quality_'.$k);?>
    <?php $counter++;?>
    <br>
<?php endforeach;?>
<?=CHtml::hiddenField('deal_id',$deal->id);?>
<br>

<script>
    $('#deal_contacts_quality_submit_link').click(function(){
        var link = $(this);
        $.ajax({
            'url':"<?=Yii::app()->createUrl('/deals/frontend/catalog/setContactsQuality');?>",
            'data': $('#setDealContactsQualityForm').serialize(),
            'type':'POST',
            'dataType': 'json',
            'beforeSend': function(){
                link.addClass('loading');
            },
            'success' : function(response){
                link.removeClass('loading');
            },
            'error': function(){
                link.removeClass('loading');
            }
        });
        return false;
    })
</script>
<a href="#" id="deal_contacts_quality_submit_link" class="btn btn-success deal-contacts-quality-submit-link"><?=Yii::t('dealsModule','Submit');?></a>
<?=CHtml::endForm();?>
<script src="/js/jquery-1.10.2.min.js"></script>
<!--<script src="/js/bootstrap.min.js"></script>-->
<!--<script src="/js/scripts.js"></script>-->
</body>
</html>


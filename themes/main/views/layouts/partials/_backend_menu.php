<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 31.03.2015
 * @var string $moduleId
 * @var string $controllerId
 * @var string $actionId
 */
/*echo '<pre>';
     var_dump($moduleId);
     var_dump($controllerId);
     var_dump($actionId);
echo '</pre>';*/
$activeClass = 'text-danger';

$unapprovedDeals = Deals::getUnapprovedDeals();
$unapprovedImages = DealsImages::model()->findAll('approve=:approve',array(':approve'=>'0'));
$unapprovedVideos = DealsVideos::model()->findAll('approve=:approve',array(':approve'=>'0'));
$unapprovedLinks = DealLinks::model()->findAll('approve=:approve',array(':approve'=>'0'));
$sizeOfUnapprovedBanners = Banners::model()->count('approve=:approve',array(':approve'=>'0'));
$sizeOfUnapprovedComments = Comments::model()->count('approve=:approve',array(':approve'=>'0'));
$sizeOfUnapprovedItems = sizeof($unapprovedDeals)+sizeof($unapprovedImages)+sizeof($unapprovedVideos)+sizeof($unapprovedLinks);

$sizeOfFeedbackItems = Feedback::model()->count('status_id=:status_id',array(':status_id'=>2));
;?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="<?=Yii::app()->createUrl('/gii');?>">
                    <span class="glyphicon glyphicon-pencil">
                    </span>
                    <?=Yii::t('gii', "Code generator");?>
                </a>
            </h4>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" class="active" href="#adminModuleMenu">
                    <span class="glyphicon glyphicon-th"></span>
                    <?=Yii::t('adminModule', "Admin");?>
                </a>
            </h4>
        </div>
        <div id="adminModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'admin' || $moduleId == 'translate')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Configuration"),
                                Yii::app()->createUrl('/admin/config/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'config') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Countries"),
                                Yii::app()->createUrl('/admin/countries/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'countries') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Cities"),
                                Yii::app()->createUrl('/admin/cities/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'cities') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Underground"),
                                Yii::app()->createUrl('/admin/underground/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'underground') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Currencies"),
                                Yii::app()->createUrl('/admin/currencies/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'currencies') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "App categories"),
                                Yii::app()->createUrl('/admin/appCategories/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'appCategories') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Lists"),
                                Yii::app()->createUrl('/admin/lists/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'lists') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Lists items"),
                                Yii::app()->createUrl('/admin/listItems/index'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'listItems') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <?php /*<tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Cleaning assets"),
                                Yii::app()->createUrl('/admin/cleaning/assets'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'cleaning') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>*/?>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('adminModule', "Cleaning cache"),
                                Yii::app()->createUrl('/admin/cleaning/cache'),
                                array(
                                    'class' => ($moduleId == 'admin' && $controllerId == 'cleaning') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('translateModule', "Translate"),
                                Yii::app()->createUrl('/translate/backend/messageSource/index'),
                                array(
                                    'class' => ($moduleId == 'translate' && $controllerId == 'backend/messageSource') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" class="active" href="#eventsModuleMenu">
                    <span class="glyphicon glyphicon-th"></span>
                    <?=Yii::t('eventsModule', "Events");?>
                </a>
            </h4>
        </div>
        <div id="eventsModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'events')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('eventsModule', "Events"),
                                Yii::app()->createUrl('/events/backend/events/index'),
                                array(
                                    'class' => ($moduleId == 'events' && $controllerId == 'backend/events') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('eventsModule', "Events types"),
                                Yii::app()->createUrl('/events/backend/eventsTypes/index'),
                                array(
                                    'class' => ($moduleId == 'events' && $controllerId == 'backend/eventsTypes') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('eventsModule', "Doings"),
                                Yii::app()->createUrl('/events/backend/doings/index'),
                                array(
                                    'class' => ($moduleId == 'events' && $controllerId == 'backend/doings') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('eventsModule', "Doings categories"),
                                Yii::app()->createUrl('/events/backend/eventsDoingsCategories/index'),
                                array(
                                    'class' => ($moduleId == 'events' && $controllerId == 'backend/eventsDoingsCategories') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#dealsModuleMenu">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <?=Yii::t('dealsModule', "Deals");?>
                </a>
                <?php if($sizeOfUnapprovedItems>0):?>
                    <span class="label label-primary"><?=$sizeOfUnapprovedItems;?></span>
                <?php endif;?>
            </h4>
        </div>
        <div id="dealsModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'deals')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Deals'),
                                Yii::app()->createUrl('/deals/backend/deals/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/deals') ? $activeClass : ''
                                )
                            );?>
                            <?php if(sizeof($unapprovedDeals)>0):?>
                                <span class="label label-primary"><?=sizeof($unapprovedDeals);?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Categories'),
                                Yii::app()->createUrl('/deals/backend/dealsCategories/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsCategories') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Images'),
                                Yii::app()->createUrl('/deals/backend/dealsImages/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsImages') ? $activeClass : ''
                                )
                            );?>
                            <?php if(sizeof($unapprovedImages)>0):?>
                                <span class="label label-primary"><?=sizeof($unapprovedImages);?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Video'),
                                Yii::app()->createUrl('/deals/backend/dealsVideos/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsVideos') ? $activeClass : ''
                                )
                            );?>
                            <?php if(sizeof($unapprovedVideos)>0):?>
                                <span class="label label-primary"><?=sizeof($unapprovedVideos);?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Links (youtube, vimeo)'),
                                Yii::app()->createUrl('/deals/backend/dealsLinks/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsLinks') ? $activeClass : ''
                                )
                            );?>
                            <?php if(sizeof($unapprovedLinks)>0):?>
                                <span class="label label-primary"><?=sizeof($unapprovedLinks);?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Params'),
                                Yii::app()->createUrl('/deals/backend/dealsParams/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsParams') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Params types'),
                                Yii::app()->createUrl('/deals/backend/dealsParamsTypes/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsParamsTypes') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Deals statuses'),
                                Yii::app()->createUrl('/deals/backend/dealsStatuses/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsStatuses') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Categories statuses'),
                                Yii::app()->createUrl('/deals/backend/dealsCategoriesStatuses/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsCategoriesStatuses') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Ratings'),
                                Yii::app()->createUrl('/deals/backend/ratings/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/ratings') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Deals contacts quality'),
                                Yii::app()->createUrl('/deals/backend/dealsContactsQuality/index'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsContactsQuality') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('dealsModule', 'Bad deals'),
                                Yii::app()->createUrl('/deals/backend/dealsStatistics/badDeals'),
                                array(
                                    'class' => ($moduleId == 'deals' && $controllerId == 'backend/dealsStatistics' && $actionId == 'badDeals') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!--<div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#adsModuleMenu">
                    <span class="glyphicon glyphicon-file"></span>
                    <?/*=Yii::t('adsModule', "Ads");*/?>
                </a>
            </h4>
        </div>
    </div>-->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="<?=Yii::app()->createUrl('/comments/backend/comments/index');?>">
                                        <span class="glyphicon glyphicon-comment">
                                        </span>
                    <?=Yii::t('commentsModule', "Comments");?>
                </a>
                <?php if($sizeOfUnapprovedComments>0):?>
                    <span class="label label-primary"><?=$sizeOfUnapprovedComments;?></span>
                <?php endif;?>
            </h4>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#cmsModuleMenu">
                    <span class="glyphicon glyphicon-check"></span>
                    <?=Rights::t('core', 'Cms');?>
                </a>
            </h4>
        </div>
        <div id="cmsModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'cms')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('core', 'Page'),
                                Yii::app()->createUrl('cms/page/index'),
                                array(
                                    'class' => ($moduleId == 'cms' && $controllerId == 'page') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('core', 'Block'),
                                Yii::app()->createUrl('cms/block/index'),
                                array(
                                    'class' => ($moduleId == 'cms' && $controllerId == 'block') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('core', 'Social media posts'),
                                Yii::app()->createUrl('cms/socialMediaPosting/index'),
                                array(
                                    'class' => ($moduleId == 'cms' && $controllerId == 'socialMediaPosting') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('core', 'Dictionary'),
                                Yii::app()->createUrl('cms/backend/dictionary/index'),
                                array(
                                    'class' => ($moduleId == 'cms' && $controllerId == 'backend/dictionary') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#messagesModuleMenu">
                    <span class="glyphicon glyphicon-list-alt"></span>
                    <?=Rights::t('messagesModule', 'Messages');?>
                </a>
            </h4>
        </div>
        <div id="messagesModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'messages')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('messagesModule', 'Dialogues'),
                                Yii::app()->createUrl('/messages/backend/dialogues/index'),
                                array(
                                    'class' => ($moduleId == 'messages' && $controllerId == 'backend/dialogues') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('messagesModule', 'Users messages'),
                                Yii::app()->createUrl('/messages/backend/userMessages/index'),
                                array(
                                    'class' => ($moduleId == 'messages' && $controllerId == 'backend/userMessages') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('messagesModule', 'Sending messages'),
                                Yii::app()->createUrl('/messages/backend/adminMessages/create'),
                                array(
                                    'class' => ($moduleId == 'messages' && $controllerId == 'backend/adminMessages') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="<?=Yii::app()->createUrl('/admin/users');?>">
                                        <span class="glyphicon glyphicon-user">
                                        </span>
                    <?=Yii::t('userModule','User');?>
                </a>
            </h4>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#rightsModuleMenu">
                    <span class="glyphicon glyphicon-check"></span>
                    <?=Rights::t('core', 'Rights');?>
                </a>
            </h4>
        </div>
        <div id="rightsModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'rights')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Rights::t('core', 'Assignments'),
                                Yii::app()->createUrl('/rights/assignment/view'),
                                array(
                                    'class' => ($moduleId == 'rights' && $controllerId == 'assignment') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Rights::t('core', 'Permissions'),
                                Yii::app()->createUrl('/rights/authItem/permissions'),
                                array(
                                    'class' => ($moduleId == 'rights' && $controllerId == 'authItem' && $actionId == 'permissions') ? $activeClass : ''
                                )

                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Rights::t('core', 'Roles'),
                                Yii::app()->createUrl('/rights/authItem/roles'),
                                array(
                                    'class' => ($moduleId == 'rights' && $controllerId == 'authItem' && $actionId == 'roles') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Rights::t('core', 'Tasks'),
                                Yii::app()->createUrl('/rights/authItem/tasks'),
                                array(
                                    'class' => ($moduleId == 'rights' && $controllerId == 'authItem' && $actionId == 'tasks') ? $activeClass : ''
                                )
                                );?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Rights::t('core', 'Operations'),
                                Yii::app()->createUrl('/rights/authItem/operations'),
                                array(
                                    'class' => ($moduleId == 'rights' && $controllerId == 'authItem' && $actionId == 'operations') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#paymentModuleMenu">
                    <span class="glyphicon glyphicon-euro"></span>
                    <?=Yii::t('paymentModule', 'Payment');?>
                </a>
            </h4>
        </div>
        <div id="paymentModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'feedback')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('paymentModule', 'Payments'),Yii::app()->createUrl('/payment/backend/payments/index'));?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div><div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#feedbackModuleMenu">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?=Yii::t('feedbackModule', 'Feedback');?>
                </a>
                <?php if($sizeOfFeedbackItems>0):?>
                    <span class="label label-primary"><?=$sizeOfFeedbackItems;?></span>
                <?php endif;?>
            </h4>
        </div>
        <div id="feedbackModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'feedback')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage messages'),Yii::app()->createUrl('/feedback/backend/feedback/index'));?>
                            <?php if($sizeOfFeedbackItems>0):?>
                                <span class="label label-primary"><?=$sizeOfFeedbackItems;?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage categories'),Yii::app()->createUrl('/feedback/backend/feedbackCategories/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage questions'),Yii::app()->createUrl('/feedback/backend/feedbackQuestions/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage messages statuses'),Yii::app()->createUrl('/feedback/backend/feedbackStatuses/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage categories statuses'),Yii::app()->createUrl('/feedback/backend/feedbackCategoriesStatuses/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('feedbackModule', 'Manage questions statuses'),Yii::app()->createUrl('feedback/backend/feedbackQuestionsStatuses/index'));?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#yiiseoModuleMenu">
                    <span class="glyphicon glyphicon-signal"></span>
                    <?=Yii::t('yiiseoModule', 'Seo');?>
                </a>
            </h4>
        </div>
        <div id="yiiseoModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'yiiseo')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('yiiseoModule', "Yii Seo"),Yii::app()->createUrl('/yiiseo/default/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('yiiseoModule', 'Categories Seo'),Yii::app()->createUrl('/yiiseo/dealsCategoriesSeo/index'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(Yii::t('yiiseoModule', 'Unfilled categories'),Yii::app()->createUrl('/yiiseo/dealsCategoriesSeo/unfilledCategories'));?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#bannersModuleMenu">
                    <span class="glyphicon glyphicon-film"></span>
                    <?=Yii::t('bannersModule', 'Banners');?>
                </a>
                <?php if($sizeOfUnapprovedBanners>0):?>
                    <span class="label label-primary"><?=$sizeOfUnapprovedBanners;?></span>
                <?php endif;?>
            </h4>
        </div>
        <div id="bannersModuleMenu" class="panel-collapse collapse <?php echo ($moduleId == 'banners')?'in':'';?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('bannersModule', 'Banners'),
                                Yii::app()->createUrl('/banners/backend/banners/index'),
                                array(
                                    'class' => ($moduleId == 'banners' && $controllerId == 'backend/banners') ? $activeClass : ''
                                )
                            );?>
                            <?php if($sizeOfUnapprovedBanners>0):?>
                                <span class="label label-primary"><?=$sizeOfUnapprovedBanners;?></span>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::link(
                                Yii::t('bannersModule', 'Banners prices'),
                                Yii::app()->createUrl('/banners/backend/bannersPrices/index'),
                                array(
                                    'class' => ($moduleId == 'banners' && $controllerId == 'backend/bannersPrices') ? $activeClass : ''
                                )
                            );?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="<?=Yii::app()->createUrl('/cms/backend/adminPages/index');?>">
                                        <span class="glyphicon glyphicon-user">
                                        </span>
                    <?=Yii::t('cmsModule','Articles');?>
                </a>
            </h4>
        </div>
    </div>
</div>
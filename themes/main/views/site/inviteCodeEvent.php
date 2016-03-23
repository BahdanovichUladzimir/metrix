<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 30.12.2015
 * @var array $users
 */
$this->breadcrumbs=array(
    Yii::t('userModule',"Invite friends event results table"),
);?>
<section>
    <h1 class="title section-title h1"><?=Yii::t('userModule','Invite friends event results');?></h1>
    <div class="panel panel-default settings-form">
        <div class="panel-body">

            <table class="table">
                <tr>
                    <td><?=Yii::t('userModule','User name');?></td>
                    <td><?=Yii::t('userModule','Count of deals');?></td>
                    <td><?=Yii::t('userModule','Count of invited users');?></td>
                    <td><?=Yii::t('userModule','Count of invited users deals');?></td>
                    <!--<td><?/*=Yii::t('userModule','Points for added deals');*/?></td>
                    <td><?/*=Yii::t('userModule','Points for invited users added deals');*/?></td>-->
                    <td><?=Yii::t('userModule','All points');?></td>
                </tr>

                <tbody>
                    <?php $counter = 0;?>
                    <?php foreach ($users as $user):?>
                        <?php if($counter<15):?>
                            <tr>
                                <td><?=CHtml::link($user['userName'], User::getPublicUrlByUserId($user['userId']));?></td>
                                <td><?=$user['dealsCount'];?></td>
                                <td><?=$user['invitedUsersCount'];?></td>
                                <td><?=$user['invitedUsersDealsCount'];?></td>
                                <!--<td><?/*=$user['pointsForAddedDeals'];*/?></td>
                                <td><?/*=$user['pointsForInvitedUsersAddedDeals'];*/?></td>-->
                                <td><?=$user['allPoints'];?></td>
                            </tr>
                        <?php endif;?>
                        <?php $counter++;?>
                    <?php endforeach;?>

                </tbody>
            </table>
        </div>
    </div>
</section>


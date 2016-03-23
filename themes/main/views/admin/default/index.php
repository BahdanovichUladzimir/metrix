<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.01.2015
 * @var int $sizeOfUsers
 * @var int $sizeOfDeals
 * @var int $sizeOfModeratedDeals
 * @var int $sizeOfNotPublishedDeals
 * @var int $sizeOfLastMonthNewUsers
 * @var int $sizeOfLastMonthNewDeals
 * @var int $sizeOfLastWeekNewDeals
 * @var int $sizeOfLastWeekNewUsers
 * @var int $sizeOfLastDayNewDeals
 * @var int $sizeOfLastDayNewUsers
 * @var int $sizeOfCurrentMonthNewUsers
 * @var int $sizeOfCurrentMonthNewDeals
 * @var int $sizeOfCurrentWeekNewUsers
 * @var int $sizeOfCurrentWeekNewDeals
 * @var int $sizeOfCurrentDayNewUsers
 * @var int $sizeOfCurrentDayNewDeals
 * @var int $sizeOfYesterdayNewUsers
 * @var int $sizeOfYesterdayNewDeals
 * @var Cities[] $cities
 */
;?>
<h1><?=Yii::t("adminModule","Welcome to admin panel");?></h1>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p>Уважаемые коллеги! Не удаляйте пожалуйста тестовые объявления, которые созданы пользователем <strong>admin</strong>! Я с ними работаю.</p>
    <p>Заранее благодарю!</p>
    <p>C уважением. Владимир (разработчик).</p>
</div>
<h3><?=Yii::t("adminModule","Site statistic");?></h3>
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab"><?=Yii::t("adminModule","General");?></a></li>
        <li role="presentation"><a href="#lastMonth" aria-controls="lastMonth" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Month");?></a></li>
        <li role="presentation"><a href="#lastWeek" aria-controls="lastWeek" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Week");?></a></li>
        <li role="presentation"><a href="#lastDay" aria-controls="lastDay" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Day");?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <h4><?=Yii::t("adminModule","General");?></h4>
            <table class="table table-striped">
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Total users");?>:</th>
                    <td><?=$sizeOfUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Total deals");?>:</th>
                    <td><?=$sizeOfDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Not published deals");?>:</th>
                    <td><?=$sizeOfNotPublishedDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Moderated deals");?>:</th>
                    <td><?=$sizeOfModeratedDeals;?></td>
                </tr>
            </table>
            <?php foreach($cities as $city):?>
                <h4><?=$city->name;?></h4>
                <table class="table table-striped">
                    <tr>
                        <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Total users");?>:</th>
                        <td><?=$city->getUsersCount();?></td>
                    </tr>
                    <tr>
                        <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Total deals");?>:</th>
                        <td><?=$city->getDealsCount();?></td>
                    </tr>
                </table>

            <?php endforeach;?>

        </div>
        <div role="tabpanel" class="tab-pane" id="lastMonth">
            <table class="table table-striped">
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last month new users");?>:</th>
                    <td><?=$sizeOfLastMonthNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last month new deals");?>:</th>
                    <td><?=$sizeOfLastMonthNewDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current month new users");?>:</th>
                    <td><?=$sizeOfCurrentMonthNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current month new deals");?>:</th>
                    <td><?=$sizeOfCurrentMonthNewDeals;?></td>
                </tr>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="lastWeek">
            <table class="table table-striped">
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last week new users");?>:</th>
                    <td><?=$sizeOfLastWeekNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last week new deals");?>:</th>
                    <td><?=$sizeOfLastWeekNewDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current week new users");?>:</th>
                    <td><?=$sizeOfCurrentWeekNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current week new deals");?>:</th>
                    <td><?=$sizeOfCurrentWeekNewDeals;?></td>
                </tr>
            </table>

        </div>
        <div role="tabpanel" class="tab-pane" id="lastDay">
            <table class="table table-striped">
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last day new users");?>:</th>
                    <td><?=$sizeOfLastDayNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Last day new deals");?>:</th>
                    <td><?=$sizeOfLastDayNewDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current day new users");?>:</th>
                    <td><?=$sizeOfCurrentDayNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Current day new deals");?>:</th>
                    <td><?=$sizeOfCurrentDayNewDeals;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Yesterday new users");?>:</th>
                    <td><?=$sizeOfYesterdayNewUsers;?></td>
                </tr>
                <tr>
                    <th class="col-md-6 col-sm-6 col-xs-6"><?=Yii::t("adminModule","Yesterday new deals");?>:</th>
                    <td><?=$sizeOfYesterdayNewDeals;?></td>
                </tr>
            </table>

        </div>
    </div>

</div>
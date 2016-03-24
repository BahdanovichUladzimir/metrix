<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.05.2015
 */

class DealsPaidCommand extends CConsoleCommand{

    public function actionWriteOffForDealsPriorityPlacement(){
        Deals::model()->updateAll(array('priority' => 0));
        $paidDeals = Deals::model()->with('user')->findAllByAttributes(array('paid' => 1, 'exceeding_category_limit_hidden' => 0));
        $paymentAmount = Yii::app()->config->get("DEALS_MODULE.PRIORITY_PLACEMENT_PAYMENT");
        foreach($paidDeals as $deal){
            /**
             * @var Deals $deal
             */
            if($deal->user->ballance>=$paymentAmount){
                $payment = new Payments();
                $payment->user_id = (int)$deal->user_id;
                $payment->type_id = 4;
                $payment->time = time();
                $payment->amount = (int)$paymentAmount;
                $payment->real_amount = (int)$paymentAmount;
                $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'deals'))->id;
                $payment->app_item_id = (int)$deal->id;
                if($payment->save()){
                    $deal->priority = 1;
                    $deal->setScenario("writeOffForDealsPriorityPlacement");
                    $deal->save();
                    Yii::log('Payment for priority goods show held successfully for deal ID-'.$deal->id.'. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForDealPriority");
                }
                else{
                    Yii::log('Payment for the show priority goods declined for deal ID-'.$deal->id.'. Model not saved. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForDealPriority");

                }
            }
            else{
                Yii::log('Payment for the show priority goods declined for deal ID-'.$deal->id.'. Insufficient Funds User. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForDealPriority");
            }
        }
    }

    //php yiic dealsPaid WriteOffForDealExceedingCategoryLimit
    /**
     *
     */
    public function actionWriteOffForDealExceedingCategoryLimit(){
        $paidDeals = Deals::model()->with('user')->findAllByAttributes(array('exceeding_limit_paid' => 1));
        foreach($paidDeals as $deal){
            $paymentAmount = $deal->getPaidAmountForExceedingLimitCategories();
            /**
             * @var Deals $deal
             */
            if($deal->user->ballance>=$paymentAmount){
                $payment = new Payments();
                $payment->user_id = (int)$deal->user_id;
                $payment->type_id = 7;
                $payment->time = time();
                $payment->amount = (int)$paymentAmount;
                $payment->real_amount = (int)$paymentAmount;
                $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'deals'))->id;
                $payment->app_item_id = (int)$deal->id;
                if($payment->save()){
                    $deal->setScenario("writeOffForDealsPriorityPlacement");
                    $deal->save();
                    Yii::log('Payment for exceeding category limit held successfully for deal ID-'.$deal->id.'. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForExceedingCategoryLimit");
                }
                else{
                    $deal->exceeding_limit_paid = 0;
                    $deal->exceeding_category_limit_hidden = 1;
                    $deal->setScenario("writeOffForDealsPriorityPlacement");
                    $deal->save();
                    Yii::log('Payment for the exceeding category limit declined for deal ID-'.$deal->id.'. Model not saved. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForExceedingCategoryLimit");

                }
            }
            else{
                $deal->exceeding_limit_paid = 0;
                $deal->exceeding_category_limit_hidden = 1;
                $deal->setScenario("writeOffForDealsPriorityPlacement");
                $deal->save();
                Yii::log('Payment for the exceeding category limit declined for deal ID-'.$deal->id.'. Insufficient Funds User. Amount - '.$paymentAmount,'info',"application.commands.dealPaidCommand.paymentForExceedingCategoryLimit");
            }
        }
    }

}
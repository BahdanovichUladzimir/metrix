<?php

class WebMoneyController extends UserFrontendController
{

    /*public function actionIndex(){
        $model = new WebmoneyPayments();
        $model->user_id = $this->userId;
        $model->purse = Yii::app()->config->get("PAYMENT_MODULE.WMB_RUR_PURSE");
        $model->description = Yii::t('paymentModule','Recharge online all4holidays.com');
        $model->email = is_null($this->user->email) ? '' : $this->user->email;
        $model->status = 1;
        $model->save(false);
        $this->render(
            'index',
            array(
                'user'=>$this->user,
                'model' => $model
            )
        );
    }*/
    public function actionSuccess(){
        Yii::app()->user->setFlash("webMoneyRecharge.success",Yii::t("paymentModule","Payment successfully held."));
        $this->redirect('/payment/user/payments/index');
    }


    public function actionFail(){

        Yii::app()->user->setFlash("webMoneyRecharge.error",Yii::t("paymentModule","During the payment error."));
        $this->redirect('/payment/user/payments/index');

    }
    public function actionResult(){

        if(isset($_POST) && isset($_POST['LMI_PREREQUEST']) && $_POST['LMI_PREREQUEST']=='1'){
            if(trim($_POST['LMI_PAYEE_PURSE'])!=Yii::app()->config->get("PAYMENT_MODULE.WMB_RUR_PURSE")){
                echo Yii::t("paymentModule","ERR: WRONG RECIPIENT PURSE ".$_POST['LMI_PAYEE_PURSE']);
                Yii::log("ERR: WRONG RECIPIENT PURSE ".$_POST['LMI_PAYEE_PURSE'],'error',"application.payments.webMoney.recharge");
                exit;
            }
            if(is_null(User::model()->findByPk(trim($_POST['id'])))){
                echo Yii::t("paymentModule","ERR: UNKNOWN USER");
                Yii::log("ERR: UNKNOWN USER",'error',"application.payments.webMoney.recharge");
                exit;
            }
            // Если ошибок не возникло и мы дошли до этого места, то выводим YES
            Yii::log("Preliminary inquiry confirmed",'info',"application.payments.webMoney.recharge");
            echo "YES";
        }
        else{
            // Задаем значение $secret_key.
            // Оно должно совпадать с Secret Key, указанным нами в настройках кошелька.
            $secret_key=Yii::app()->params['webMoney']['secretKey'];

            // Склеиваем строку параметров
            $common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].
                $_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].
                $_POST['LMI_SYS_TRANS_DATE'].$secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
            // Шифруем полученную строку в SHA256 и переводим ее в верхний регистр
            $hash = strtoupper(hash("sha256",$common_string));
            // Прерываем работу скрипта, если контрольные суммы не совпадают
            if($hash!=$_POST['LMI_HASH']){
                Yii::log('Checksums do not match.','error',"application.payments.webMoney.recharge");
                exit;
            }
            $transaction = Yii::app()->db->beginTransaction();


            $payment = new Payments();
            $payment->user_id = (int)$_POST['LMI_PAYMENT_NO'];
            $payment->type_id = 5;
            $payment->time = time();
            $payment->amount = (int)$_POST['LMI_PAYMENT_AMOUNT'];
            $payment->real_amount = (int)$_POST['LMI_PAYMENT_AMOUNT'];
            $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'users'))->id;
            $payment->app_item_id = (int)$_POST['LMI_PAYMENT_NO'];
            if($payment->save()){
                $transaction->commit();
                Yii::log('User balance successfully replenished with WebMoney. User ID - '.$payment->user_id.'. Amount - '.$payment->amount.".",'info',"application.payments.webMoney.recharge");
            }
            else{
                $transaction->rollback();
                Yii::log('When saving Payments model error occurred. User ID - '.$payment->user_id.'. Amount - '.$payment->amount.". Model not saved.",'error',"application.payments.webMoney.recharge");

            }
        }
    }

}

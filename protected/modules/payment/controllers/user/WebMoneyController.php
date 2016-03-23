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
        /**
         * @var $model WebmoneyPayments
         */
        $model = WebmoneyPayments::model()->findByPk($_POST['LMI_PAYMENT_NO']);
        $model->status = 3;
        $model->save();
        Yii::app()->user->setFlash("webMoneyRecharge.error",Yii::t("paymentModule","During the payment error."));
        $this->redirect('/payment/user/payments/index');

    }
    public function actionResult(){
        if($_POST['LMI_PREREQUEST']==1){
            if(trim($_POST['LMI_PAYEE_PURSE'])!=Yii::app()->config->get("PAYMENT_MODULE.WMB_RUR_PURSE")){
                echo Yii::t("paymentModule","ERR: WRONG RECIPIENT PURSE ".$_POST['LMI_PAYEE_PURSE']);
                exit;
            }
            if(is_null(User::model()->findByPk(trim($_POST['id'])))){
                echo Yii::t("paymentModule","ERR: UNKNOWN USER");
                exit;
            }
            // Если ошибок не возникло и мы дошли до этого места, то выводим YES
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
            if($hash!=$_POST['LMI_HASH']) exit;
            /**
             * @var $model WebmoneyPayments
             */
            $transaction = Yii::app()->db->beginTransaction();
            $model = WebmoneyPayments::model()->findByPk((int)$_POST['LMI_PAYMENT_NO']);
            $model->amount = (int)$_POST['LMI_PAYMENT_AMOUNT'];
            $model->created_at = date("Y-m-d H:i:s");
            $model->description = $_POST['LMI_PAYMENT_DESC'];
            //$model->email = $_POST['email'];
            $model->status = 2;
            if($model->save(false)){
                $payment = new Payments();
                $payment->user_id = $model->user_id;
                $payment->type_id = 5;
                $payment->time = time();
                $payment->amount = $model->amount;
                $payment->real_amount = $model->amount;
                $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'users'))->id;
                $payment->app_item_id = $model->user_id;
                if($payment->save()){
                    $transaction->commit();
                    Yii::log('User balance successfully replenished with WebMoney. User ID - '.$model->user_id.'. Amount - '.$model->amount.".",'info',"application.payments.webMoney.recharge");
                }
                else{
                    $transaction->rollback();
                    Yii::log('When saving Payments model error occurred. User ID - '.$model->user_id.'. Amount - '.$model->amount.". Model not saved.",'info',"application.payments.webMoney.recharge");

                }
            }
            else{
                $transaction->rollback();
                Yii::log('When saving WebmoneyPayments model error occurred. User ID - '.$model->user_id.'. Amount - '.$model->amount.". Model not saved.",'info',"application.payments.webMoney.recharge");
            }
        }
    }

}

<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.06.2015
 */

class EmailCommand extends CConsoleCommand{

    public function actionSendGmailInvites(){
        $criteria = new CDbCriteria();
        $criteria->order = 't.id ASC';
        $criteria->select = 'invite_email';
        $criteria->limit = 10;
        $criteria->with = array('user');
        $invites = GmailInvites::model()->findAll($criteria);
        if(sizeof($invites)>0){
            foreach($invites as $invite){
                $isSendMail = UserModule::sendSmtpMail(
                    $invite->invite_email,
                    Yii::app()->params['adminEmail'],
                    Yii::t('userModule',Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_SUBJECT')),
                    Yii::t('userModule',Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_MESSAGE'), array('{user}'=>$invite->user->getCommentUserName()))
                );
                if($isSendMail){
                    $invite->invite_email;
                    $invite->delete();
                }
            }
        }
    }

    public function actionSendEmails(){
        $criteria = new CDbCriteria();
        $criteria->order = 't.id ASC';
        $criteria->condition = ":is_sent=t.is_sent";
        $criteria->params = array(":is_sent" => 0);
        $criteria->limit = 10;
        $messages = EmailMessages::model()->findAll($criteria);
        if(sizeof($messages)>0){
            foreach($messages as $message){
                $isSendMail = UserModule::sendSmtpMail(
                    $message->to,
                    $message->from,
                    $message->subject,
                    $message->message
                );
                if($isSendMail){
                    $message->sent_date = time();
                    $message->is_sent = 1;
                    $message->save();
                    Yii::log("Message \"".$message->message."\" was sent from ".$message->from." to ".$message->to." successfully",CLogger::LEVEL_INFO,'emailCommand');
                }
                else{
                    Yii::log("Message \"".$message->message."\" wasn't sent from ".$message->from." to ".$message->to, CLogger::LEVEL_ERROR,'emailCommand');
                }
            }
        }
        else{
            var_dump("Nope messages to send");
        }
    }

    public function actionSendInfoMessage(){
        $sql = "
            SELECT m.sender_id AS messageSenderId, d.sender_id AS dialogSenderId, d.receiver_id as dialogReceiverId FROM UserMessages m
            LEFT JOIN Dialogues d ON(d.id=m.dialog_id)
            WHERE m.is_read='0' AND m.created_at<".strtotime(date('Y-m-d',time())).";
        ";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $rows=$command->queryAll();
        $receivers = array();
        foreach ($rows as $row) {
            if($row['messageSenderId'] == $row['dialogSenderId']){
                $infoMessageReceiverId = $row['dialogReceiverId'];
            }
            elseif($row['messageSenderId'] == $row['dialogReceiverId']){
                $infoMessageReceiverId = $row['dialogSenderId'];
            }
            else{
                $infoMessageReceiverId = 0;
            }
            if(!array_key_exists($infoMessageReceiverId,$receivers)){
                $receivers[$infoMessageReceiverId] = 1;
            }
            else{
                $receivers[$infoMessageReceiverId] = $receivers[$infoMessageReceiverId]+1;
            }
        }
        foreach($receivers as $k=>$v){
            $user = User::model()->findByPk($k);
            if($user->subscribe == '1'){
                $data = array(
                    'user' => $user,
                    'sizeOfMessages' => $v
                );
                $message = $this->render('infoMessage',$data);
                $messagesModel = new EmailMessages();
                $messagesModel->from = Yii::app()->params['adminEmail'];
                $messagesModel->to = $user->email;
                $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                $messagesModel->message = $message;
                $messagesModel->type_id = 1;
                $messagesModel->is_sent = 0;
                $messagesModel->created_date = time();
                $messagesModel->recipient_id = $user->id;
                $messagesModel->save();
            }
        }
    }

    private function render($template, array $data = array()){
        $path = Yii::getPathOfAlias('application.views.email').'/'.$template.'.php';
        if(!file_exists($path)) throw new Exception('Template '.$path.' does not exist.');
        return $this->renderFile($path, $data, true);
    }
}
<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 07.04.2015
 */

class GmailController extends UserFrontendController{

    public function actionInviteFriends($accessToken){

        $this->render(
            'invite_friends',
            array(
                'accessToken' => $accessToken,
                'registeredEmails' => User::getRegisteredEmails(),
            )
        );
    }

    public function actionInvite(){
        if(isset($_POST) && isset($_POST['emails']) && (sizeof($_POST['emails']))>0){
            $emails = $_POST['emails'];
            $save = true;
            foreach($emails as $email){
                $inviteModel = new GmailInvites();
                $inviteModel->user_id = $this->userId;
                $inviteModel->invite_email = $email;
                if(!$inviteModel->save()){
                    $save = false;
                    break;
                }
            }
            if($save){
                Yii::app()->user->setFlash('usermodule.gmail.invite.success', 'Your invites was sent successfully!');
            }
            else{
                Yii::app()->user->setFlash('usermodule.gmail.invite.error', 'When sent invites error occurred!');
            }
            if(isset($_POST['access_token'])){
                $this->render(
                    'invite_friends',
                    array(
                        'accessToken' => $_POST['access_token'],
                        'registeredEmails' => User::getRegisteredEmails()
                    )
                );
            }
            else{
                $this->redirect(Yii::app()->createUrl('/user/profile'));
            }
        }
    }

    public function actionCheckEmails(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['emails'])){
                $userId = Yii::app()->user->getId();
                $emailsArray = json_decode($_POST['emails']);
                $registeredEmails = User::getRegisteredEmails();
                $emails = array();
                foreach($emailsArray as $val){
                    $inviteExists = GmailInvites::model()->find('user_id=:user_id AND invite_email=:invite_email', array(':user_id' => $userId, ':invite_email' => $val));
                    if(is_null($inviteExists)){
                        if(!in_array($val, $registeredEmails)){
                            $email = array(
                                'email' => $val,
                                'status' => 'not_registered'
                            );
                        }
                        else{
                            $email = array(
                                'email' => $val,
                                'status' => 'registered'
                            );
                        }
                        array_push($emails,$email);
                    }

                }
                echo json_encode(array(
                    'emails' => $emails
                ));
            }
        }
    }
}
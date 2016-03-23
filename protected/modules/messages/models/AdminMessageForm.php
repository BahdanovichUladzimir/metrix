<?php

/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.10.2015
 */
class AdminMessageForm extends CFormModel
{
    public $message;
    public $subject;
    public $group;
    public $sendToEmail;
    public $sendToCabinet;
    /**
     * @var User[]
     */
    public $users = array();

    public static $groups = array();

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */

    public function init(){
        parent::init();
        self::$groups = array(
            "all" => "All",
            "hasDeals" => "Has deals",
            "hasNotDeals" => "Has not deals",
        );
        self::$groups = array_merge(
            self::$groups,
            CHtml::listData(DealsCategories::getRootCategories(false,false),"id","name")
        );
    }
    public function rules()
    {
        return array(
            array('message', 'length', "max" => 1000),
            array('subject', 'length', "max" => 300),
            array('message, group', 'required'),
            array('sendToEmail, sendToCabinet', 'boolean'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'message' => Yii::t('messagesModule',"Message"),
            'group' => Yii::t('messagesModule',"Group"),
            'sendToEmail' => Yii::t('messagesModule',"Send To Email"),
            'sendToCabinet' => Yii::t('messagesModule',"Send To Cabinet"),
        );
    }
    public function send(){
        switch ($this->group) {
            case "all":
                $this->users = User::model()->findAll();
                break;
            case "hasDeals":
                /**
                 * @var User[] $users
                 */
                $users = User::model()->findAll();
                foreach($users as $user){
                    if($user->hasDeals()){
                        $this->users[] = $user;
                    }
                }
                break;
            case "hasNotDeals":
                /**
                 * @var User[] $users
                 */
                $users = User::model()->findAll();
                foreach($users as $user){
                    if(!$user->hasDeals()){
                        $this->users[] = $user;
                    }
                }
                break;
            default:
                $category = DealsCategories::model()->findByPk($this->group);
                if(!is_null($category)){
                    /**
                     * @var User[] $users
                     */
                    $criteria = new CDbCriteria();
                    $criteria->with = array(
                        'deals' => array(
                            'with' => array(
                                'categories' => array(
                                    'condition' => "categories.id=:id",
                                    'params' => array(
                                        ":id" => $category->id
                                    )
                                )
                            ),
                        ),
                    );
                    $this->users = User::model()->findAll($criteria);
                    Config::var_dump($this->users);
                }
        }

        foreach($this->users as $user){
            if($this->sendToCabinet == "1"){
                UserMessages::sendMessage(1,$user->id,$this->message);
            }
            if($this->sendToEmail == "1"){
                if(!is_null($user->email) && strlen(trim($user->email))>0){
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $user->email;
                    $messagesModel->subject = strlen(trim($this->subject))>0 ? $this->subject : Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $this->message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $user->id;
                    $messagesModel->save();
                }
            }
        }
        return true;

    }
}
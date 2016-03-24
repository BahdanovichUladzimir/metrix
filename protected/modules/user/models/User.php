<?php
/**
 * The followings are the available columns in table 'users':
 * @property string $create_at
 * @property string $lastvisit_at
 * @property Deals[] $deals
 * @property Banners[] $banners
 * @property Deals[] $publicDeals
 * @property Profile $profile
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property float $ballance
 * @property string $identity
 * @property string $provider
 * @property string $access_token
 * @property int $access_token_expires
 * @property string $full_name
 * @property int $state
 * @property string $agreement
 * @property string $subscribe
 * @property UsersIps[] $usersIps
 * @property Events[] $events
 * @property string $activkey
 * @property string $invitekey
 * @property string $invitecode

 */
class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	private $_url = NULL;
	private $_publicUrl = NULL;
	private $_privateUrl = NULL;

    /**
     * @param string $className
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Yii::t('userModule',"Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => Yii::t('userModule',"Incorrect password (minimal length 4 symbols).")),
			array('invitekey, invitecode', 'length', 'max'=>128, 'min' => 4),
			array('email', 'email'),
			array('username', 'unique', 'message' => Yii::t('userModule',"This user's name already exists.")),
			array('email', 'unique', 'message' => Yii::t('userModule',"This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Yii::t('userModule',"Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, superuser, status', 'required'),
			array('email', 'required', 'except' => 'generateInviteKey'),
            array('provider, identity, full_name, access_token', 'length', 'max'=>255),
            array('superuser, status, access_token_expires', 'numerical', 'integerOnly'=>true),
            array('access_token_expires', 'length', 'max'=>20),
			array('ballance', 'numerical'),
			array('agreement, subscribe', 'boolean', 'falseValue' => '0', 'trueValue' => '1'),
			array('id, username, password, email, activkey, invitekey, invitecode, create_at, lastvisit_at, superuser, status', 'safe', 'on'=>'search'),
        ):((Yii::app()->user->id==$this->id)?array(
			array('username', 'required'),
			array('email', 'required' ,'except' => 'vkUserCreate, fbUserCreate, setInviteCode, agreement, unsubscribe'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Yii::t('userModule',"Incorrect username (length between 3 and 20 characters).")),
			array('access_token_expires', 'length', 'max'=>20),
			array('provider, identity, full_name, access_token', 'length', 'max'=>255),
			array('email', 'email'),
            array('ballance', 'numerical'),
            array('state, access_token_expires', 'numerical', "integerOnly" => true),
            array('state', 'length', 'max'=>1),
            array('username', 'unique', 'message' => Yii::t('userModule',"This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Yii::t('userModule',"Incorrect symbols (A-z0-9).")),
			array('identity', 'unique', 'message' => Yii::t('userModule',"This user's identity already exists.")),
			array('email', 'unique', 'message' => Yii::t('userModule',"This user's email address already exists.")),
            array('agreement, subscribe', 'boolean', 'falseValue' => '0', 'trueValue' => '1'),
            array('invitekey, invitecode', 'length', 'max'=>128, 'min' => 4),

        ):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
            'deals' => array(self::HAS_MANY, 'Deals', 'user_id'),
            'banners' => array(self::HAS_MANY, 'Banners', 'user_id'),
            'publicDeals' => array(
                self::HAS_MANY,
                'Deals',
                'user_id',
                'condition' => '`publicDeals`.`approve`=:approve AND `publicDeals`.`archive`=:archive AND `publicDeals`.`status_id`=:status_id',
                'params' => array(
                    ':approve' => 1,
                    ':archive' => 0,
                    ':status_id' => 1,
                )
            ),
            'payments' => array(self::HAS_MANY, 'Payments', 'user_id'),
            'usersIps' => array(self::HAS_MANY, 'UsersIps', 'user_id'),
            'events' => array(self::HAS_MANY, 'Events', 'user_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('userModule',"Id"),
			'username'=>Yii::t('userModule',"username"),
			'password'=>Yii::t('userModule',"password"),
			'verifyPassword'=>Yii::t('userModule',"Retype Password"),
			'email'=>Yii::t('userModule',"E-mail"),
			'verifyCode'=>Yii::t('userModule',"Verification Code"),
			'activkey' => Yii::t('userModule',"Activation key"),
			'invitekey' => Yii::t('userModule',"Invite key"),
			'createtime' => Yii::t('userModule',"Registration date"),
			'create_at' => Yii::t('userModule',"Registration date"),
			'lastvisit_at' => Yii::t('userModule',"Last visit"),
			'superuser' => Yii::t('userModule',"Superuser"),
			'status' => Yii::t('userModule',"Status"),
			'ballance' => Yii::t('userModule',"Balance"),
			'identity' => Yii::t('userModule',"Identity"),
			'provider' => Yii::t('userModule',"Provider"),
			'full_name' => Yii::t('userModule',"Full name"),
			'state' => Yii::t('userModule',"State"),
            'access_token_expires' => Yii::t('userModule',"Access token expires"),
            'agreement' => Yii::t('userModule',"Agreement"),
            'subscribe' => Yii::t('userModule',"Subscribe"),
            'usersIps' => Yii::t('userModule',"IPs"),
            'invitecode' => Yii::t('userModule','Invite code'),
        );
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, invitekey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.ballance, user.full_name, user.agreement, user.subscribe, user.invitekey, user.invitecode, user.activkey',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => Yii::t('userModule','Not active'),
				self::STATUS_ACTIVE => Yii::t('userModule','Active'),
				self::STATUS_BANNED => Yii::t('userModule','Banned'),
			),
			'AdminStatus' => array(
				'0' => Yii::t('userModule','No'),
				'1' => Yii::t('userModule','Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('user.id',$this->id);
        $criteria->compare('user.username',$this->username,true);
        $criteria->compare('user.password',$this->password);
        $criteria->compare('user.email',$this->email,true);
        $criteria->compare('user.activkey',$this->activkey);
        $criteria->compare('user.invitekey',$this->invitekey);
        $criteria->compare('user.create_at',$this->create_at);
        $criteria->compare('user.lastvisit_at',$this->lastvisit_at);
        $criteria->compare('user.superuser',$this->superuser);
        $criteria->compare('user.status',$this->status);
        $criteria->compare('user.identity',$this->identity);
        $criteria->compare('user.provider',$this->provider);
        $criteria->compare('user.state',$this->state);
        $criteria->compare('user.full_name',$this->full_name);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

	public function getAdminUrl() {
		if ($this->_url === null) {
			$this->_url = Yii::app()->createUrl('/user/backend/default/view', array('id' => $this->id));
		}
		return $this->_url;
	}

	public function getPublicUrl(){
		if ($this->_publicUrl === null) {
			$this->_publicUrl = Yii::app()->createUrl('/user/profile/publicProfile', array('id' => $this->id));
		}
		return $this->_publicUrl;
	}

	public function getPrivateUrl(){
		if ($this->_privateUrl === null) {
			$this->_privateUrl = Yii::app()->createUrl('/user/profile/privateProfile');
		}
		return $this->_privateUrl;
	}
	public static function getAllUsersListData(){
		return CHtml::listData(User::model()->findAll(),'id', 'username');
	}

    public function getLargeAvatar(){
        return $this->profile->getLargeThumbUrl();
    }
    public function getMediumAvatar(){
        return $this->profile->getMediumThumbUrl();
    }
    public function getSmallAvatar(){
        return $this->profile->getSmallThumbUrl();
    }
    public function getAvatar(){
        return $this->profile->getImageUrl();
    }

    public function getBallance(){
        if(is_null($this->ballance)){
            $this->ballance = 0;
        }
        return $this->ballance;
    }

    public function getCommentUserName(){
        if(!is_null($this->full_name) && strlen(trim($this->full_name))>0){
            return $this->full_name;
        }
        elseif(!is_null($this->profile->first_name) && strlen($this->profile->first_name)>0){

            $userName = $this->profile->first_name;
            if(!is_null($this->profile->last_name) && strlen($this->profile->last_name)>0){
                $userName.=" ".$this->profile->last_name;
            }
            return $userName;
        }
        elseif(!is_null($this->username) && strlen($this->username)>0){
            return $this->username;
        }
        else{
            return $this->id;
        }
    }

    public static function getRegisteredEmails(){
        $sql = 'SELECT `email` from `Users`';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $registeredEmails = array();
        foreach ($dataReader as $row) {
            array_push($registeredEmails, $row['email']);
        }
        return $registeredEmails;
    }

    public static function generateRandomUniqueUserName($prefix = ''){
        $username = $prefix.Yii::app()->getSecurityManager()->generateRandomString(8);
        if(is_null(self::model()->find(':username=username', array(':username'=>$username)))){
            return $username;
        }
        else{
            return self::generateRandomUniqueUserName($prefix);
        }
    }

    public static function generateRandomUniqueUserInviteKey($prefix = ''){
        $invitekey = $prefix.Yii::app()->getSecurityManager()->generateRandomString(8);
        if(is_null(self::model()->find(':invitekey=invitekey', array(':invitekey'=>$invitekey)))){
            return $invitekey;
        }
        else{
            return self::generateRandomUniqueUserName($prefix);
        }
    }

    public function beforeSave(){
        if($this->isNewRecord){
            $this->setCreatetime(time());
            $this->setLastvisit(time());
            $this->invitekey = self::generateRandomUniqueUserInviteKey();
        }
        /*if($this->isNewRecord || $this->getScenario() == "setInviteCode"){
            if(!is_null($this->invitecode) && is_string($this->invitecode) && strlen(trim($this->invitecode))>0){
                $invitedUser = self::model()->findByAttributes(array('invitekey' => trim($this->invitecode)));
                if(!is_null($invitedUser)){
                    $bonus = 20000;
                    self::addBonus($invitedUser->id,$bonus);
                }
            }
        }*/


        return parent::beforeSave();
    }
    public function beforeDelete(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'sender_id=:sender_id OR receiver_id=:receiver_id';
        $criteria->params = array(
            ':sender_id' => $this->id,
            ':receiver_id' => $this->id
        );
        if(Dialogues::model()->deleteAll($criteria)){
            return parent::beforeDelete();
        }
        else{
            return false;
        }
    }

    public function hasDeals(){
        if(sizeof($this->deals)>0){
            return true;
        }
        return false;
    }

    public function getLastIp(){
        $ips = UsersIps::model()->findAllByAttributes(array("user_id" => $this->id));
        if(sizeof($ips)>0){
            $lastIp = end($ips)->ip;
        }
        else{
            $lastIp = '';
        }
        return $lastIp;
    }


    public static function addBonus($user_id, $bonus){

        /*var_dump($user_id);
        var_dump($bonus);
        exit();*/

    }

    public static function getPublicUrlByUserId($id){
        return Yii::app()->createUrl('/user/profile/publicProfile', array('id' => $id));
    }


}
<?php

/**
 * This is the model class for table "Banners".
 *
 * The followings are the available columns in table 'Banners':
 * @property string $id
 * @property integer $user_id
 * @property string $link
 * @property string $image
 * @property string $name
 * @property integer $approve
 * @property integer $published
 * @property string $paid_end_date
 *
 * The followings are the available model relations:
 * @property User $user
 * @property BannersCats[] $bannersCats
 * @property BannersCities[] $bannersCities
 * @property DealsCategories[] $categories
 * @property Cities[] $cities
 */
class Banners extends CActiveRecord
{
    public $file;

    public $publicDate = NULL;
    public $unixPaidDate = NULL;
	public static $approves = array();
	public static $publishes = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Banners';
	}

	public function init(){
		self::$approves = array(
			0 => Yii::t("bannersModule","Not approve"),
			1 => Yii::t("bannersModule","Approve")
		);
		self::$publishes = array(
			0 => Yii::t("bannersModule","Not published"),
			1 => Yii::t("bannersModule","Published")
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, approve, published', 'numerical', 'integerOnly'=>true),
			array('link, image, name, paid_end_date', 'length', 'max'=>255),
			array('link', 'length'),
			array('name', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, link, image, name, approve, published, paid_end_date', 'safe', 'on'=>'search'),
            array(
                'file',
                'EPictureValidator',
                'minWidth' => 265,
                'minHeight' => 100,
                'maxWidth' => 300,
                'maxHeight' => 500,
                'allowEmpty' => false,
                'on' => "userCreate"
            ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'bannersCats' => array(self::HAS_MANY, 'BannersCats', 'banner_id'),
			'categories' => array(self::MANY_MANY,  'DealsCategories', 'BannersCats(banner_id, category_id)'),
			'cities' => array(self::MANY_MANY,  'Cities', 'BannersCities(banner_id, city_id)'),
			'bannersCities' => array(self::HAS_MANY, 'BannersCities', 'banner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("bannersModule",'ID'),
			'user_id' => Yii::t("bannersModule",'User ID'),
			'link' => Yii::t("bannersModule",'Link'),
			'image' => Yii::t("bannersModule",'Image'),
			'name' => Yii::t("bannersModule",'Name'),
			'approve' => Yii::t("bannersModule",'Approve'),
			'published' => Yii::t("bannersModule",'Published'),
			'categories' => Yii::t("bannersModule",'Categories'),
			'cities' => Yii::t("bannersModule",'Cities'),
			'user' => Yii::t("bannersModule",'User'),
			'paid_end_date' => Yii::t("bannersModule",'Paid end date'),
		);
	}
    public function behaviors(){
        return array(
            'uploadableBanner'=>array(
                'fileAttributeName' => 'file',
                'fileNameAttributeName' => 'image',
                'idAttributeName' => 'id',
                'subFolderNameAttributeName' => 'id',
                'scenarios' => array("userCreate"),
                //'isCreateSubfolder' => false,
                'class'=>'application.components.UploadableBannerBehavior',
                'savePathAlias'=>'webroot.uploads.banners',
                'fileTypes'=>Yii::app()->config->get('BANNERS_MODULE.BANNER_ALLOWED_IMAGES_FILE_TYPES'),
                'emptyImageUrl' => Yii::app()->config->get("BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_URL"),
                'emptyImagePath' => Yii::app()->config->get("BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_PATH"),
            ),
			'ESaveRelatedBehavior' => array(
				'class' => 'application.components.ESaveRelatedBehavior'
			)

        );
    }


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->order = 'approve ASC';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('approve',$this->approve);
		$criteria->compare('published',$this->published);
		$criteria->compare('paid_end_date',$this->paid_end_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function beforeSave(){
		if($this->getIsNewRecord()){
			$this->paid_end_date = date('Y-m-d H:i:s',time());
		}
		if(!Yii::app()->getModule('user')->isAdmin()){
			$this->approve = 0;
			if(!is_null($this->user) && !is_null($this->user->email) && strlen(trim($this->user->email))>0){
				$message = Yii::t(
						'bannersModule',
						"Dear {userName}! Banner \"{name}\" was sent for moderation.",
						array(
								'{userName}' => CHtml::encode($this->user->username),
								'{name}' => CHtml::encode($this->name)
						)
				);
				/*$messagesModel = new EmailMessages();
				$messagesModel->from = Yii::app()->params['adminEmail'];
				$messagesModel->to = $this->user->email;
				$messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
				$messagesModel->message = $message;
				$messagesModel->type_id = 1;
				$messagesModel->is_sent = 0;
				$messagesModel->created_date = time();
				$messagesModel->recipient_id = $this->user->id;
				$messagesModel->save();*/
				UserMessages::sendMessage(1,$this->user_id,$message);
			}
		}
		return parent::beforeSave();
	}

    public function beforeDelete()
    {
        if (!is_null($this->user) && !is_null($this->user->email) && strlen(trim($this->user->email)) > 0 && ($this->user_id != Yii::app()->user->getId())) {
            $message = Yii::t(
                'bannersModule',
                "Dear {userName}! Banner \"{name}\" was deleted.",
                array(
                    '{userName}' => CHtml::encode($this->user->username),
                    '{name}' => CHtml::encode($this->name)
                )
            );
            /*$messagesModel = new EmailMessages();
            $messagesModel->from = Yii::app()->params['adminEmail'];
            $messagesModel->to = $this->user->email;
            $messagesModel->subject = Yii::t('dealsModule', 'Message from all4holidays.com');;
            $messagesModel->message = $message;
            $messagesModel->type_id = 1;
            $messagesModel->is_sent = 0;
            $messagesModel->created_date = time();
            $messagesModel->recipient_id = $this->user->id;
            $messagesModel->save();*/
            UserMessages::sendMessage(1, $this->user_id, $message);

        }
        return parent::beforeDelete();
    }
    public function afterFind(){
        if(!is_null($this->paid_end_date)){
            $this->publicDate = date("d-m-Y", strtotime($this->paid_end_date));
            $date = DateTime::createFromFormat('!Y-m-d H:i:s', $this->paid_end_date);
            $this->unixPaidDate = $date->format('U');
        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banners the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPrivateUrl(){
		return Yii::app()->createUrl("/banners/user/banners/update", array("id"=> $this->id));
	}
	public function getImageUrl(){
        if(!$this->isNewRecord){
            return Yii::app()->createUrl("/uploads/banners/".$this->id."/".$this->image);
        }
        else{
            return "";
        }
	}

	public function getTodayClicks(){
        $model = BannersClicks::model()->findByAttributes(array('banner_id' => $this->id, 'date' => date("Y-m-d", time())));
        return (is_null($model)) ? 0 : $model->clicks_count;
    }
	public function getYesterdayClicks(){
        $model = BannersClicks::model()->findByAttributes(array('banner_id' => $this->id, 'date' => date("Y-m-d", time()-60*60*24)));
        return (is_null($model)) ? 0 : $model->clicks_count;
    }
	public function getLastMonthClicks(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'banner_id=:banner_id';
        $criteria->params = array(
            ":banner_id" => $this->id
        );
        $criteria->addBetweenCondition('date',date("Y-m-d", time()-60*60*24*30),date("Y-m-d", time()));

        $models = BannersClicks::model()->findAll($criteria);
        $clicks = 0;
        foreach($models as $model){
            $clicks+=$model->clicks_count;
        }
        return $clicks;
    }

	public function getPaymentAmount($days = 30){
        $paymentAmount = 0;
        foreach($this->cities as $city){
            foreach($this->categories as $category){
                $tmpPrice = BannersPrices::model()->findByAttributes(array('city_id' => $city->id, 'category_id' => $category->id));
                $price = is_null($tmpPrice) ? 20 : $tmpPrice;
                $paymentAmount+=($price->price*$days);
            }
        }
        return $paymentAmount;
	}
}

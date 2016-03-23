<?php

/**
 * This is the model class for table "DealsImages".
 *
 * The followings are the available columns in table 'DealsImages':
 * @property string $id
 * @property string $name
 * @property string $file_name
 * @property string $ext
 * @property string $path
 * @property string $dir_path
 * @property string $dir_url
 * @property string $url
 * @property string $description
 * @property integer $width
 * @property integer $height
 * @property string $deal_id
 * @property integer $approve
 * @property integer $preview
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Deals $deal
 */
class DealsImages extends CActiveRecord
{
	public $largeThumbUrl = NULL;
	public $mediumThumbUrl = NULL;
	public $smallThumbUrl = NULL;
	public $largeThumbPath = NULL;
	public $mediumThumbPath = NULL;
	public $smallThumbPath = NULL;
	public $largeThumbEmptyUrl = NULL;
	public $mediumThumbEmptyUrl = NULL;
	public $smallThumbEmptyUrl = NULL;
	public $largeThumbEmptyPath = NULL;
	public $mediumThumbEmptyPath = NULL;
	public $smallThumbEmptyPath = NULL;
	public $emptyUrl = NULL;
	public $emptyPath = NULL;

	public function init(){
		$this->largeThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_EMPTY_URL");
		$this->mediumThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL");
		$this->smallThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_EMPTY_URL");
		$this->largeThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_EMPTY_PATH");
		$this->mediumThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_PATH");
		$this->smallThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_EMPTY_PATH");
		$this->emptyUrl = Yii::app()->config->get("DEALS_MODULE.EMPTY_ORIGINAL_IMG_URL");
		$this->emptyPath = Yii::app()->config->get("DEALS_MODULE.EMPTY_ORIGINAL_IMG_PATH");
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsImages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('width, height, approve', 'numerical', 'integerOnly'=>true),
			array('name, file_name, path, dir_path, dir_url, url, alias', 'length', 'max'=>255),
			array('description', 'length', 'max'=>400),
			array('ext', 'length', 'max'=>5),
			array('approve, preview', 'length', 'max'=>1),
			array('preview', 'checkPreviewsCount', "on" => "setPreviews"),
			array('deal_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, file_name, ext, path, url, description, width, height, deal_id, dir_path, dir_url, alias', 'safe', 'on'=>'search'),
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	public function checkPreviewsCount($attribute,$params){
        if(isset($this->preview) && !is_null($this->preview) && $this->preview == "1"){
            $sizeOfPreviews = self::model()->countByAttributes(array('deal_id' => $this->deal_id,"preview" => 1));
            if($sizeOfPreviews>2){
                $this->addError('preview',Yii::t("dealsModule","You can define a maximum of 3 images to preview."));
            }
        }
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dealsModule','Image ID'),
			'name' => Yii::t('dealsModule','Image name'),
			'file_name' => Yii::t('dealsModule','Image file name'),
			'ext' => Yii::t('dealsModule','Image file extension'),
			'path' => Yii::t('dealsModule','Image path'),
			'dir_path' => Yii::t('dealsModule','Image directory path'),
			'dir_url' => Yii::t('dealsModule','Image directory URL'),
			'url' => Yii::t('dealsModule','Image URL'),
			'description' => Yii::t('dealsModule','Description'),
			'width' => Yii::t('dealsModule','Image width'),
			'height' => Yii::t('dealsModule','Image height'),
			'deal_id' => Yii::t('dealsModule','Deal ID'),
			'approve' => Yii::t('dealsModule','Approve label'),
			'preview' => Yii::t('dealsModule','Preview label'),
            'alias' => Yii::t('dealsModule','Image name'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('dir_path',$this->dir_path,true);
		$criteria->compare('dir_url',$this->dir_url,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
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
	public function adminSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = 'approve ASC';

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('dir_path',$this->dir_path,true);
		$criteria->compare('dir_url',$this->dir_url,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterFind(){
		parent::afterFind();
		$this->largeThumbUrl = $this->dir_url.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->file_name;
		$this->mediumThumbUrl = $this->dir_url.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->file_name;
		$this->smallThumbUrl = $this->dir_url.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->file_name;
		$this->largeThumbPath = $this->dir_path.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->file_name;
		$this->mediumThumbPath = $this->dir_path.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->file_name;
		$this->smallThumbPath = $this->dir_path.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->file_name;
	}

    public function beforeSave(){
        if(!Yii::app()->getModule('user')->isAdmin()){
            $this->approve = 0;
            /*if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0){
                $name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->file_name;
                $message = Yii::t(
                    'dealsModule',
                    "Dear {userName}! Image \"{name}\" was sent to moderation.",
                    array(
                        '{userName}' => $this->deal->user->username,
                        '{name}' => $name
                    )
                );
                $messagesModel = new EmailMessages();
                $messagesModel->from = Yii::app()->params['adminEmail'];
                $messagesModel->to = $this->deal->user->email;
                $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                $messagesModel->message = $message;
                $messagesModel->type_id = 1;
                $messagesModel->is_sent = 0;
                $messagesModel->created_date = time();
                $messagesModel->recipient_id = $this->deal->user->id;
                $messagesModel->save();
				UserMessages::sendMessage(1,$this->deal->user_id,$message);

			}*/
        }
        return parent::beforeSave();
    }

	public function beforeDelete(){
		if(file_exists($this->largeThumbPath)){
			unlink($this->largeThumbPath);
		}
		if(file_exists($this->mediumThumbPath)){
			unlink($this->mediumThumbPath);
		}
		if(file_exists($this->smallThumbPath)){
			unlink($this->smallThumbPath);
		}
		if(file_exists($this->path)){
			unlink($this->path);
		}
		if(!file_exists($this->largeThumbPath) && !file_exists($this->mediumThumbPath) && !file_exists($this->smallThumbPath) && !file_exists($this->path)){
			if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0 && ($this->deal->user_id != Yii::app()->user->getId())){
                $name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->file_name;
				$message = Yii::t(
					'dealsModule',
					"Dear {userName}! Image \"{name}\" was deleted.",
					array(
						'{userName}' => $this->deal->user->username,
						'{name}' => $name
					)
				);

				/*$messagesModel = new EmailMessages();
				$messagesModel->from = Yii::app()->params['adminEmail'];
				$messagesModel->to = $this->deal->user->email;
				$messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
				$messagesModel->message = $message;
				$messagesModel->type_id = 1;
				$messagesModel->is_sent = 0;
				$messagesModel->created_date = time();
                $messagesModel->recipient_id = $this->deal->user->id;
                $messagesModel->save();*/
				UserMessages::sendMessage(1,$this->deal->user_id,$message);
			}
			return parent::beforeDelete();
		}
		else{
			return false;
		}
	}

	public function getLargeThumbUrl(){
		if(file_exists($this->largeThumbPath) && is_file($this->largeThumbPath)){
			return $this->largeThumbUrl;
		}
		else{
			return $this->largeThumbEmptyUrl;
		}
	}
	public function getMediumThumbUrl(){
		if(file_exists($this->mediumThumbPath) && is_file($this->mediumThumbPath)){
			return $this->mediumThumbUrl;
		}
		else{
			return $this->mediumThumbEmptyUrl;
		}

	}
	public function getSmallThumbUrl(){
		if(file_exists($this->smallThumbPath) && is_file($this->smallThumbPath)){
			return $this->smallThumbUrl;
		}
		else{
			return $this->smallThumbEmptyUrl;
		}

	}
	public function getImageUrl(){
		if(file_exists($this->path) && is_file($this->path)){
			return $this->url;
		}
		else{
			return $this->emptyUrl;
		}

	}

	public static function getApproveListData(){
		return array(0=>'Not approved',1=>'Approved');
	}

    public static function getSizeOfPreviews($dealId){
        return self::model()->countByAttributes(array('deal_id' => $dealId,"preview" => 1));
    }

}

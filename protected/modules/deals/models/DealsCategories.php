<?php

/**
 * This is the model class for table "DealsCategories".
 *
 * The followings are the available columns in table 'DealsCategories':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $url_segment
 * @property string $description
 * @property string $status_id
 * @property string $image
 * @property string $file
 * @property array $filter
 * @property int $no_index
 * @property int $for_adults
 * @property int $priority
 * @property int $page_count
 * @property int $free_deals_count
 * @property int $paid_placement_price
 * @property DealsCategoriesSeo $seo
 *
 * The followings are the available model relations:
 * @property DealsCategoriesStatuses $status
 * @property DealsCategoriesParams[] $dealsCategoriesParams
 * @property DealsCategoriesRatings[] $dealsCategoriesRatings
 * @property DealsDealsCategories[] $dealsDealsCategories
 * @property DealsParams[] $filtersParams
 * @property DealsParams[] $params
 * @property Ratings[] $ratings
 * @property Deals[] $deals
 * @property DealsCategories $parent
 */
class DealsCategories extends CActiveRecord
{
    private $_parent = NULL;
    private $_children = NULL;
    private $_publishedChildren = NULL;
    private $_url = NULL;
    private $_publicUrl = NULL;
    public $largeThumbUrl = NULL;
    public $mediumThumbUrl = NULL;
    public $smallThumbUrl = NULL;
    public $largeThumbPath = NULL;
    public $mediumThumbPath = NULL;
    public $smallThumbPath = NULL;

    public $imagesDirPath = NULL;
    public $imagesDirUrl = NULL;
    public $originalImagePath = NULL;
    public $originalImageUrl = NULL;
    public $children;

    private $_hasCoordinatesParam = NULL;
    private $_hasParent = NULL;
    private $_parentsIds = NULL;

    public function getBreadcrumbs($isLastItemIsLink = false ,$userCityKey = 'msk') {
        $breadcrumbs = array();

        if($this->parent !== null){
            $breadcrumbs = $this->parent->getBreadcrumbs(true, $userCityKey); // get the parent as a link
        }

        if($isLastItemIsLink){
            $breadcrumbs[$this->name] = $this->getPublicUrl($userCityKey);
        }
        else{
            $breadcrumbs[] = $this->name;
        }


        return $breadcrumbs;
    }

    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'DealsCategories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, parent_id, status, url_segment, paid_placement_price, page_count, free_deals_count, status_id, description', 'required'),
            array('parent_id', 'length', 'max'=>11),
            array('page_count, free_deals_count', 'length', 'max'=>10),
            array('page_count', 'default', 'value'=>20),
            array('free_deals_count', 'default', 'value'=>20),
            array('name, url_segment, image, paid_placement_price', 'length', 'max'=>255),
            array('no_index, for_adults', 'length', 'max'=>1),
            array('priority', 'length', 'max'=>2),
            array('no_index, page_count, free_deals_count, paid_placement_price', 'numerical', 'integerOnly'=>true),
            array('status_id', 'length', 'max'=>3),
            array('description', 'safe'),

            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, parent_id, name, url_segment, image, description, status_id, no_index, for_adults, priority, page_count, free_deals_count, paid_placement_price', 'safe', 'on'=>'search'),
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
            'status' => array(self::BELONGS_TO, 'DealsCategoriesStatuses', 'status_id'),
            'dealsCategoriesParams' => array(
                self::HAS_MANY,
                'DealsCategoriesParams',
                'deal_category_id',
                'order' => 'dealsCategoriesParams.deal_param_id ASC'
            ),
            'filtersParams' => array(self::MANY_MANY,
                'DealsParams',
                'DealsCategoriesParams(deal_category_id, deal_param_id)',
                'condition' => 'filter=:filter',
                'params' => array(
                    ':filter' => 1
                ),
                'order' => 'filtersParams.name ASC'
            ),
            'dealsCategoriesRatings' => array(self::HAS_MANY, 'DealsCategoriesRatings', 'category_id'),
            'dealsDealsCategories' => array(self::HAS_MANY, 'DealsDealsCategories', 'category_id'),
            'parent' => array(self::BELONGS_TO, 'DealsCategories', 'parent_id'),
            'children' => array(self::HAS_MANY, 'DealsCategories', 'id'),
            'params' => array(self::MANY_MANY,  'DealsParams', 'DealsCategoriesParams(deal_category_id, deal_param_id)'),
            'ratings' => array(self::MANY_MANY,  'Ratings', 'DealsCategoriesRatings(category_id, rating_id)'),
            'deals' => array(self::MANY_MANY,  'Deals', 'Deals_DealsCategories(category_id, deal_id)'),
            'seo' => array(self::HAS_ONE,  'DealsCategoriesSeo', 'category_id'),

        );
    }

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.no_index = 0 AND t.status_id = 1',
            ),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dealsModule','ID'),
            'parent_id' => Yii::t('dealsModule','Parent category'),
            'name' => Yii::t('dealsModule','Name'),
            'url_segment' => Yii::t('dealsModule','URL segment'),
            'description' => Yii::t('dealsModule','Description'),
            'status_id' => Yii::t('dealsModule','Status'),
            'image' => Yii::t('dealsModule','Image name'),
            'file' => Yii::t('dealsModule','Image'),
            'no_index' => Yii::t('dealsModule','No index'),
            'for_adults' => Yii::t('dealsModule','For adults'),
            'priority' => Yii::t('dealsModule','Priority'),
            'page_count' => Yii::t('dealsModule','Page deals count'),
            'free_deals_count' => Yii::t('dealsModule','Free deals count'),
            'paid_placement_price' => Yii::t('dealsModule','Paid placement price'),
        );
    }

    public function behaviors(){
        return array(
            'ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior'
            ),
            'uploadableFile'=>array(
                'class'=>'application.components.UploadableFileBehavior',
                'savePathAlias'=>'webroot.uploads.deals_categories',
                'fileTypes'=>Yii::app()->config->get('DEALS_MODULE.ALLOWED_IMAGES_FILE_TYPES'),
                'largeThumbEmptyUrl' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_LARGE_THUMB_EMPTY_URL"),
                'largeThumbEmptyPath' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_LARGE_THUMB_EMPTY_PATH"),
                'mediumThumbEmptyUrl' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_MEDIUM_THUMB_EMPTY_URL"),
                'mediumThumbEmptyPath' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_MEDIUM_THUMB_EMPTY_PATH"),
                'smallThumbEmptyUrl' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_SMALL_THUMB_EMPTY_URL"),
                'smallThumbEmptyPath' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_SMALL_THUMB_EMPTY_PATH"),
                'emptyImageUrl' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_ORIGINAL_IMG_EMPTY_URL"),
                'emptyImagePath' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_ORIGINAL_IMG_EMPTY_PATH"),
                'largeThumbWidth' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_LARGE_THUMB_WIDTH"),
                'largeThumbHeight' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_LARGE_THUMB_HEIGHT"),
                'mediumThumbWidth' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_MEDIUM_THUMB_WIDTH"),
                'mediumThumbHeight' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_MEDIUM_THUMB_HEIGHT"),
                'smallThumbWidth' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_SMALL_THUMB_WIDTH"),
                'smallThumbHeight' => Yii::app()->config->get("DEALS_MODULE.CATEGORY_SMALL_THUMB_HEIGHT"),
                'smallThumbPrefix' => Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX"),
                'mediumThumbPrefix' => Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX"),
                'largeThumbPrefix' => Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX"),
            ),
            'CyrillicUrlTranslateBehavior' => array(
                'class'=>'application.components.CyrillicUrlTranslateBehavior',
                'inputAttributeName' => 'name',
                'outputAttributeName' => 'url_segment'
            ),
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

        $criteria->compare('id',$this->id);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('name',$this->name, true);
        //$criteria->compare('url_segment',$this->url_segment,true);
        //$criteria->compare('description',$this->description,true);
        $criteria->compare('status_id',$this->status_id);
        //$criteria->compare('for_adults',$this->for_adults);
        $criteria->compare('free_deals_count',$this->free_deals_count);
        $criteria->compare('page_count',$this->page_count);
        $criteria->compare('priority',$this->priority);
        //$criteria->compare('image',$this->image,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>50,
            ),
            'sort' => array(
                'defaultOrder' => 'parent_id ASC',
            ),

        ));
    }

    /**
     * @return DealsCategories
     */
    public function getParent(){
        if($this->_parent === NULL){
            $this->_parent = self::model()->findByPk($this->parent_id);
        }
        return $this->_parent;
    }

    public function hasParent(){
        if(is_null($this->_hasParent)){
            $this->_hasParent = (is_null($this->getParent())) ? false : true;
        }
        return $this->_hasParent;
    }

    /**
     * @return array
     */
    public function getChildren(){
        if(is_null($this->_children)){
            $criteria = new CDbCriteria;
            $criteria->condition = ':parent_id=parent_id';
            $criteria->order = 'priority DESC, name ASC';
            $criteria->params = array(
                ':parent_id' => $this->id,
            );
            $this->_children = self::model()->findAll($criteria);
        }
        return $this->_children;
    }
    /**
     * @return array
     */
    public function getPublishedChildren(){
        if(is_null($this->_publishedChildren)){
            $criteria = new CDbCriteria;
            $criteria->condition = 'parent_id=:parent_id AND status_id=:status_id';
            $criteria->order = 'priority DESC, name ASC';
            $criteria->params = array(
                ':parent_id' => $this->id,
                ':status_id' => 1,
            );
            $this->_publishedChildren = self::model()->findAll($criteria);
        }
        return $this->_publishedChildren;
    }

    /**
     * @return array
     */
    public function getChildrenListData(){
        $children = $this->getChildren();
        $childrenListData = array();
        if(sizeof($children)>0){
            foreach($children as $child){
                /**
                 * @var $child $this
                 */
                $childrenListData[$child->id] = CHtml::link($child->name,$child->getAdminUrl());
            }
        }
        return $childrenListData;
    }
    public function getChildrenDropdownListData($isAddNoneItem = true, $published = false){
        if($published){
            $children = $this->getPublishedChildren();
        }
        else{
            $children = $this->getChildren();
        }
        $childrenListData = array();
        if($isAddNoneItem){
            $childrenListData = array(
                0 => Yii::t("dealsModule","None")
            );
        }
        if(sizeof($children)>0){
            foreach($children as $child){
                /**
                 * @var $child $this
                 */
                $childrenListData[$child->id] = $child->name;
            }
        }
        return $childrenListData;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DealsCategories the static model class
     */
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    /**
     * @param bool $structured
     * @param bool $isNoneItem
     * @param int $nestedLevel
     * @param bool $isGetParents
     * @return array
     * return list data array for dropdown widget
     */
    public static function getListData($structured = true, $isNoneItem = true, $nestedLevel = NULL, $isGetParents = true){
        if(!is_null($nestedLevel)){
            $nestedLevel = (int)$nestedLevel;
        }
        else{
            $nestedLevel = (int)Yii::app()->config->get("DEALS_MODULE.CATEGORIES_NESTED_LEVEL");
        }
        if($structured){
            if($isNoneItem){
                return self::getDropdownItems(0, 1, $nestedLevel, $isGetParents)+array(0=>Yii::t("dealsModule",'None'));
            }
            else{
                return self::getDropdownItems(0, 1, $nestedLevel, $isGetParents);
            }
        }
        else{
            $listData = CHtml::listData(self::model()->findAll(array('order'=>'name ASC')),'id','name');
            if($isNoneItem){
                $listData = array_merge(array(0 => array(1 => Yii::t('dealsModule', 'None'))),$listData);
            }
            return $listData;
        }
    }

    public static function getDropdownItems($parentId=0, $level=1, $nestedLevel = NULL, $isGetParents = true){

        if(!is_null($nestedLevel)){
            $nestedLevel = (int)$nestedLevel;
        }
        else{
            $nestedLevel = (int)Yii::app()->config->get("DEALS_MODULE.CATEGORIES_NESTED_LEVEL");
        }
        $categoriesFormatted = array();
        $categories = self::model()->findAllByAttributes(array(
            'parent_id' => $parentId,
        ));
        foreach ($categories as $category){
            if($level <= $nestedLevel){
                $children = self::getDropdownItems((int)$category->id, $level+1, $nestedLevel, $isGetParents);
                if($isGetParents){
                    $categoriesFormatted[(int)$category->id] = str_repeat('-', $level-1) ." ".$category->name;
                    $categoriesFormatted = $categoriesFormatted+$children;
                }
                else{
                    if($level == $nestedLevel){
                        $categoriesFormatted[(int)$category->id] = $category->name;
                    }
                    $categoriesFormatted = $categoriesFormatted+$children;

                }
            }
        }
        return $categoriesFormatted;
    }

    public static function getCategoryFilterParamsWithParentCategoryFilterParamsRecursively(DealsCategories $category){
        $params = $category->filtersParams;
        if($category->hasParent()){
            $parentParams = self::getCategoryFilterParamsWithParentCategoryFilterParamsRecursively($category->getParent());
            $params = array_merge($params,$parentParams);
        }
        $uniqueParamsNames = array();
        $uniqueParams = array();
        foreach($params as $param){
            if(!in_array($param->name,$uniqueParamsNames)){
                $uniqueParamsNames[] = $param->name;
                $uniqueParams[] = $param;
            }
        }
        return $uniqueParams;
    }

    public static function getParentsRecursively(DealsCategories $category){
        $parents = array();
        if($category->hasParent()){
            $parent = $category->getParent();
            $parents = array($parent);
            if($parent->hasParent()){
                $parentParents = self::getParentsRecursively($parent);
                $parents = array_merge($parents,$parentParents);
            }
        }

        return $parents;
    }


    public function getParentsParamsIds(){
        $parents = self::getParentsRecursively($this);
        $excludedParamsIds = array();
        if(sizeof($parents)>0){
            foreach($parents as $parent){
                foreach($parent->params as $param){
                    $excludedParamsIds[] = $param->id;
                }
            }
        }
        return $excludedParamsIds;
    }

    public function getParentsParams(){
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';
        $criteria->addInCondition('id', $this->getParentsParamsIds());
        return DealsParams::model()->findAll($criteria);
    }

    public function getAvailableParamsListData(){
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';
        $criteria->addNotInCondition('id', $this->getParentsParamsIds());
        return CHtml::listData(DealsParams::model()->findAll($criteria),'id','label');
    }


    public static function getRootCategories($limit = 12,$rand = false){
        $criteria = new CDbCriteria();
        $criteria->condition = 'parent_id=:parent_id AND status_id=:status_id';
        $criteria->params = array(
            ':parent_id' => 0,
            ':status_id' => 1
        );
        if($limit){
            $criteria->limit = $limit;
        }
        $criteria->order = $rand ? 'rand()' : 'priority DESC, name ASC';
        $categories = self::model()->findAll($criteria);
        return $categories;
    }

    public static function getRootCategoriesIds($limit = 12,$rand = false){
        $criteria = new CDbCriteria();
        $criteria->condition = 'parent_id=:parent_id AND status_id=:status_id';
        $criteria->select = 'id';
        $criteria->params = array(
            ':parent_id' => 0,
            ':status_id' => 1
        );
        if($limit){
            $criteria->limit = $limit;
        }
        $criteria->order = $rand ? 'rand()' : 'priority DESC, name ASC';
        $categories = self::model()->findAll($criteria);
        $ids = array();
        foreach($categories as $category){
            array_push($ids,$category->id);
        }
        return $ids;
    }


    public function getAdminUrl() {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl('/deals/backend/dealsCategories/view', array('id' => $this->id));
        }
        return $this->_url;
    }

    public function getPublicUrl($cityKey = 'mnsk'){
        if ($this->_publicUrl === null) {
            $this->_publicUrl = Yii::app()->createUrl("/deals/frontend/catalog/index", array('city' => $cityKey, 'urlSegment' => $this->url_segment));
        }
        return $this->_publicUrl;

    }

    public static function getPublicUrlByCatId($cat_id, $cityKey){
        $tempDealCat = self::model()->findByPk($cat_id);
        return $tempDealCat!==null ? $tempDealCat->getPublicUrl($cityKey) : '';
    }

    public static function getPublicLinkByCatId($cat_id, $cityKey, $htmlOptions = array()){
        $tempDealCat = self::model()->findByPk($cat_id);
        return $tempDealCat!==null ? CHtml::link($tempDealCat->name, $tempDealCat->getPublicUrl($cityKey), $htmlOptions) : '';
    }


    protected function afterFind(){
        parent::afterFind();
        $this->imagesDirPath = realpath(Yii::app()->getBasePath()."/../uploads/deals_categories/").DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR;
        $this->imagesDirUrl = Yii::app( )->getBaseUrl( )."/uploads/deals_categories/".$this->id."/";
        $this->largeThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->image;
        $this->mediumThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->image;
        $this->smallThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->image;
        $this->largeThumbPath = $this->imagesDirPath.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->image;
        $this->mediumThumbPath = $this->imagesDirPath.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->image;
        $this->smallThumbPath = $this->imagesDirPath.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->image;
        $this->originalImagePath = $this->imagesDirPath.$this->image;
        $this->originalImageUrl = $this->imagesDirUrl.$this->image;

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
        if(file_exists($this->originalImagePath) && is_file($this->originalImagePath)){
            return $this->originalImageUrl;
        }
        else{
            return $this->largeThumbEmptyUrl;
        }

    }

    public function beforeDelete(){
        $children = $this->getChildren();
        foreach($children as $child){
            $child->parent_id = 0;
            if(!$child->save()){
                return false;
            }
        }
        return parent::beforeDelete();
    }
    public function getParamsString(){
        $params = array();
        foreach($this->params as $param)
        {
            /**
             * @var $category DealsCategories
             */
            $params[$param->id] = $param->label;
        }
        return implode(',<br> ', $params);
    }

    public function afterSave(){
        if($this->for_adults == "1"){
            $children = self::getCategoryChildrenRecursively($this->id);
            foreach($children as $child){
                $child->for_adults = "1";
                $child->save();
            }
        }
        return parent::afterSave();
    }

    public function hasCoordinatesParam(){
        if(!is_null($this->_hasCoordinatesParam)){
            return $this->_hasCoordinatesParam;
        }
        else{
            $this->_hasCoordinatesParam = false;
            foreach ($this->getCategoryParamsWithParentCategoryParamsRecursively() as $param){
                if($param->type->name == 'coordinates_widget'){
                    $this->_hasCoordinatesParam = true;
                    break;
                }
            }
        }
        return $this->_hasCoordinatesParam;
    }
    public function getCategoryParamsWithParentCategoryParamsRecursively(){
        $params = $this->params;
        if($this->hasParent()){
            $parentParams = $this->getParent()->getCategoryParamsWithParentCategoryParamsRecursively();
            $params = array_merge($params,$parentParams);
        }
        return $params;
    }



    public static function hasChildren($categoryId){
        if(sizeof(self::getCategoryChildren($categoryId))>0){
            return true;
        }
        return false;
    }

    public static function getCategoryChildren($categoryId, $published = true){
        $criteria = new CDbCriteria;

        $criteria->condition = ':parent_id=parent_id';
        $criteria->params = array(
            ':parent_id' => $categoryId,
        );
        if($published){
            $criteria->addCondition('status_id=:status_id');
            $criteria->params[':status_id'] = 1;
        }
        $criteria->order = 'name ASC';
        return self::model()->findAll($criteria);
    }

    public static function getCategoriesChildren($categoriesIds = array(), $published = true){
        $criteria = new CDbCriteria;
        if($published){
            $criteria->condition = 'status_id=:status_id';
            $criteria->params = array(
                ':status_id' => 1,
            );
        }

        $criteria->addInCondition('parent_id',$categoriesIds);
        $criteria->order = 'name ASC';
        return self::model()->findAll($criteria);
    }

    /**
     * @param int $categoryId
     * @return DealsCategories[]
     */
    public static function getCategoryChildrenRecursively($categoryId = 0){
        $criteria = new CDbCriteria;
        $criteria->condition = ':parent_id=parent_id AND status_id=:status_id';
        $criteria->params = array(
            ':parent_id' => $categoryId,
            ':status_id' => 1,
        );
        $categories = self::model()->findAll($criteria);
        foreach($categories as $category){
            $categories = array_merge($categories,self::model()->getCategoryChildrenRecursively($category->id));
        }
        return $categories;
    }

    public static function getCategoryChildrenIdsRecursively($categoryId = 0){
        $connection = Yii::app()->db;
        $sql = "SELECT `id`, `name` FROM DealsCategories WHERE parent_id=$categoryId";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $array = array();
        foreach ($dataReader as $row) {
            array_push($array, $row['id']);
            $array = array_merge($array,self::model()->getCategoryChildrenIdsRecursively($row['id']));
        }
        return $array;
    }

    public function getFiltersParams(){
        return $this->filtersParams;
    }

    public static function getNoIndexListData(){
        return array('0' => 'index', '1' => 'no index');
    }

    public static function getRootParent($id){
        $category = self::model()->findByPk($id);
        if(!$category->hasParent()){
            return $category;
        }
        else{
            return self::getRootParent($category->getParent()->id);
        }
    }
}

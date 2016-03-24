<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.05.2015
 */

class SocialMediaCommand extends CConsoleCommand{

    public $vkAccessToken = NULL;
    public $vkAppId = NULL;
    public $vkSecretKey = NULL;
    public $vkGroupId = NULL;
    public $vkAlbumId = NULL;

    public function init(){
        $this->vkAccessToken = Yii::app()->params['vk']['accessToken'];
        $this->vkAppId = Yii::app()->params['vk']['appId'];
        $this->vkSecretKey = Yii::app()->params['vk']['secretKey'];
        $this->vkGroupId = Yii::app()->params['vk']['groupId'];
        $this->vkAlbumId = Yii::app()->params['vk']['albumId'];
    }
    public function actionPostingToVk(){
        Yii::import('vendor.vk.VkApi');
        $criteria = new CDbCriteria();
        $criteria->condition = 'network=:network AND status=:status AND post_date_time<=:post_date_time';
        $criteria->params = array(
            ':network' => 1,
            ':status' => 2,
            ':post_date_time' => date('Y-m-d H:i:s',time())
        );
        $posts = SocialMediaPosting::model()->findAll($criteria);

        if(sizeof($posts)>0){
            $vk = new VkApi($this->vkAppId,$this->vkAccessToken);
            foreach($posts as $post){
                $response = array();
                // Если тип страница, просто постим её
                if($post->type == '1'){
                    $photos = array();
                    $dom = new domDocument();
                    $dom->loadHTML($post->description);
                    $dom->preserveWhiteSpace = false;
                    $imgs  = $dom->getElementsByTagName("img");
                    $links = array();
                    for($i = 0; $i < $imgs->length; $i++) {
                        $links[] = $imgs->item($i)->getAttribute("src");
                    }
                    $cleanDescription = html_entity_decode(strip_tags(trim($post->description)));
                    if(sizeof($links)>0){
                        $images = array();
                        if(YII_ENV == "local.dev"){
                            $rootPath = 'D:\OpenServer\domains\all4holidays';
                        }
                        elseif(YII_ENV == "dev"){
                            $rootPath = '/var/www/dev.all4holidays';
                        }
                        elseif(YII_ENV == "rc"){
                            $rootPath = '/var/www/rc.all4holidays';
                        }
                        else{
                            $rootPath = '/var/www/all4holidays';
                        }
                        foreach($links as $link){
                            $filePath = urldecode($rootPath.$link);

                            if(file_exists($filePath)){
                                $images[] = $filePath;
                            }
                            else{
                                var_dump($filePath." - file not found");
                            }
                        }
                        $result = $vk->uploadImages($this->vkAlbumId,$this->vkGroupId, $images, $post->title);
                        if(isset($result->error)){
                            Yii::log(
                                "When upload images to Vk error occurred! Vk error code - ".$result->error->error_code.". Error message - ".$result->error->error_msg.".",
                                CLogger::LEVEL_ERROR,
                                'application.commands.socialMediaCommand.postingToVk');
                        }
                        elseif($result && is_array($result)&& sizeof($result)>0){
                            Yii::log("Images uploaded to Vk successfully.", CLogger::LEVEL_INFO,'application.commands.socialMediaCommand.postingToVk');
                            foreach ($result as $uploadedImages) {
                                $photos[] = "photo".$uploadedImages->owner_id."_".$uploadedImages->pid;
                            }
                        }
                        else{

                        }
                        if(!is_null($post->link) && strlen(trim($post->link))>0){
                            $response = $vk->wallPostMessage($this->vkGroupId, $cleanDescription, $post->link.",".implode(',',$photos));
                        }
                        else{
                            $response = $vk->wallPostMessage($this->vkGroupId, $cleanDescription,"https://all4holidays.com,".implode(',',$photos));
                        }
                    }
                    else{
                        $response = $vk->wallPostMessage($this->vkGroupId, $cleanDescription, (!is_null($post->link) && strlen(trim($post->link))>0) ? $post->link : "https://all4holidays.com");

                    }
                }
                // Если тип deal, то выбираем картинки товара, загружаем их в альбом и привязываем к посту
                elseif($post->type == "2"){
                    //var_dump($post->type);
                    $cleanDescription = strip_tags(trim($post->description));
                    $photos = array();
                    if(sizeof($post->images)>0){
                        $images = array();
                        foreach($post->images as $image){
                            /**
                             * @var SocialMediaPostingImages $image
                             */
                            $images[] = $image->image->largeThumbPath;
                            $image->status = 2;
                            $image->save();
                        }
                        // Загружаем картинки на сервер вк
                        $result = $vk->uploadImages($this->vkAlbumId,$this->vkGroupId, $images, $post->title);
                        if(isset($result->error)){
                            Yii::log(
                                "When upload images to Vk error occurred! Vk error code - ".$result->error->error_code.". Error message - ".$result->error->error_msg.".",
                                CLogger::LEVEL_ERROR,
                                'application.commands.socialMediaCommand.postingToVk');
                        }
                        elseif($result && is_array($result)&& sizeof($result)>0){
                            Yii::log("Images uploaded to Vk successfully.", CLogger::LEVEL_INFO,'application.commands.socialMediaCommand.postingToVk');
                            foreach ($result as $uploadedImages) {
                                $photos[] = "photo".$uploadedImages->owner_id."_".$uploadedImages->pid;
                            }
                            foreach ($post->images as $image) {
                                /**
                                 * @var SocialMediaPostingImages $image
                                 */
                                $image->status = 3;
                                $image->save();
                            }
                        }
                        else{

                        }
                    }
                    if(!is_null($post->link) && strlen(trim($post->link))>0){
                        $response = $vk->wallPostMessage($this->vkGroupId, $cleanDescription, $post->link.",".implode(',',$photos));
                    }
                    else{
                        $response = $vk->wallPostMessage($this->vkGroupId, $cleanDescription,"https://all4holidays.com,".implode(',',$photos));
                    }
                }
                if(isset($response->response->post_id)){
                    $post->status = 3;
                    $post->posted_date_time = date("Y-m-d H:i:s");
                    $post->save();
                    Yii::log("Post \"".$post->title."\" was published to vk successfully!",CLogger::LEVEL_INFO,'application.commands.socialMediaCommand.postingToVk');
                }
                elseif(isset($response->error)){
                    Yii::log(
                        "When publish post \"".$post->title."\" to Vk error occurred! Vk error code - ".$response->error->error_code.". Error message - ".$response->error->error_msg.".",
                        CLogger::LEVEL_ERROR,
                        'application.commands.socialMediaCommand.postingToVk');

                }

                //1.https://oauth.vk.com/authorize?client_id=5206269&scope=offline,wall,groups,photos&redirect_uri=http://api.vkontakte.ru/blank.html&response_type=code
                    // ответ - http://api.vkontakte.ru/blank.html#code=6f8e305e77de766344
                //2.https://oauth.vk.com/access_token?client_id=5206269&client_secret=8zFkQIYoKFXsfOcTPTnS&code=70b550f244dbd6b46f&redirect_uri=http://api.vkontakte.ru/blank.html
                    // ответ - {"access_token":"c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37","expires_in":0,"user_id":154208502}
                //3.https://api.vkontakte.ru/method/wall.post?owner_id=-110115205&=&access_token=c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37&from_group=1&message=TestMessageApi&attachment=http://dev.all4holidays.com
            }
        }
    }

    /*public function actionPostingToFb(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'network=:network AND status=:status AND post_date_time<=:post_date_time';
        $criteria->params = array(
            ':network' => 2,
            ':status' => 2,
            ':post_date_time' => date('Y-m-d H:i:s',time())
        );
        $posts = SocialMediaPosting::model()->findAll($criteria);
        if(sizeof($posts)>0){
            foreach($posts as $post){
                var_dump($post->title);
            }
        }
    }*/

    /*public function postToVkGroup($text,$link="")
    {
        $accessToken = "c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37";

        $groupId = "-110115205";

        $text = urlencode($text);
        $link = urlencode($link);

        $request = "https://api.vkontakte.ru/method/wall.post?owner_id=".$groupId."&access_token=".$accessToken."&message=".$text."&attachment=".$link."&from_group=1";

        // ответ от Вконтакте
        $response = json_decode(file_get_contents($request));
        return $response;
    }*/


}
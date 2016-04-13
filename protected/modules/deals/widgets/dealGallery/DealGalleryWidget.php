<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.03.2015
 */

class DealGalleryWidget extends CWidget{

    /**
     * @var Deals
     */
    public $deal = NULL;
    public $videosLimit = NULL;
    public $photosLimit = NULL;
    public $template = 'default';
    public static $widgetId = 0;
    public $images = array();
    public $videos = array();
    public $links = array();
    public $userVideos = array();

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        if(Yii::app()->user->getId() == $this->deal->user_id || Yii::app()->getModule('user')->isModerator()){
            $this->images = $this->deal->dealsImages;
            $this->videos = $this->deal->dealsVideos;
            $this->links = $this->deal->dealLinks;
        }
        else{
            $this->images = $this->deal->frontendDealsImages;
            $this->videos = $this->deal->frontendDealsVideos;
            $this->links = $this->deal->frontendDealLinks;
        }

        foreach($this->videos as $video){
            $userVideo = array(
                'url' => $video->url,
                'previewUrl' => $video->getMediumThumbUrl(),
                'type' => 'video',
            );
            $this->userVideos[] = $userVideo;
        }
        foreach($this->links as $dealLink){
            $userLink = array(
                'url' => $dealLink->link
            );
            if($dealLink->link_type == 'youtube'){
                $userLink['type'] = 'youtube';
                $userLink['previewUrl'] = $dealLink->getMediumThumbUrl();
            }
            else{
                $userLink['type'] = 'vimeo';
                $userLink['previewUrl'] = $dealLink->getMediumThumbUrl();
            }
            $this->userVideos[] = $userLink;
        }
        if((sizeof($this->images) == 0) && (sizeof($this->userVideos) == 0)){
            return false;
        }

        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'videosLimit' => $this->videosLimit,
                'photosLimit' => $this->photosLimit,
                'userVideos' => $this->userVideos,
                'widgetId' => self::$widgetId,
                'images' => $this->images,
                'videos' => $this->videos,
                'links' => $this->links,
            )
        );
    }
}
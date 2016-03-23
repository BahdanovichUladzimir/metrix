
<?php
/*
В данном классе реализованы две функции. Публикация на стену и загрузка изображения в альбом.
*/
class VkApi{

    private $user_id;
    private $access_token;
    private $user_agent;

    public function __construct($user_id, $access_token/*, $imagePath*/)
    {
        $this->user_id = $user_id;
        $this->access_token = $access_token;
        //$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        //$this->imagePath = $imagePath;
    }


    public function api($method, $param, $data = array()) {
        if(sizeof($data)>0){
            $data['access_token'] = $this->access_token;
            $res = $this->curlPost("https://api.vk.com/method/".$method, $data);
        }
        else{
            $res = $this->curlPost("https://api.vk.com/method/$method?$param&access_token=$this->access_token", array());
        }
        return json_decode($res);
    }

    public function postApi($method,$data = array()){
        $data['access_token'] = $this->access_token;
        $res = $this->curlPost("https://api.vk.com/method/".$method, $data);
        return json_decode($res);
    }


    public function wallMessage($gid, $msg, $url) {


        if (is_int($msg[0]))
            $msg .= '%20'.$msg;


        $msg = str_replace(' ', '%20', $msg);

        $server = $this->api("wall.post","owner_id=-$gid&message=$msg&attachments=$url&from_group=1");
        return $server;

    }
    public function wallPostMessage($gid, $msg, $url) {


        if (is_int($msg[0]))
            $msg .= '%20'.$msg;


        //$msg = str_replace(' ', '%20', $msg);

        $data = array(
            'owner_id' => "-".$gid,
            'message' => $msg,
            'attachments' => $url,
            'from_group=1'
        );
        $server = $this->postApi("wall.post",$data);
        return $server;

    }

    //"https://api.vk.com/method/wall.post?owner_id=-110115205&message=Компьютерные%20игры%20Компьютерные%20игры%20Компьютерные%20игры%20Компьютерные%20игры&attachments=http://dev.all4holidays.com/msk/dj/tets-35,photo-110115205_394195098,photo-110115205_394195099,photo-110115205_394195100&from_group=1&access_token=c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37"
    //"https://api.vk.com/method/wall.post?owner_id=-110115205&message=Тестовый%20дескрипшн%20по  ста&attachments=http://dev.all4holidays.com/cms/page/view/1&from_group=1&access_token=c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37"
    public function uploadImg($aid, $gid, $imagePath, $text) {

        $text = str_replace(' ', '%20', $text);


        $data = array("file1"=>"@".$imagePath);

        $server = $this->api("photos.getUploadServer","album_id=$aid&group_id=$gid");

        $res = $this->curlPost($server->response->upload_url, $data);
        $upload = json_decode($res);
        $save = $this->api("photos.save", "caption=$text&album_id={$upload->aid}&group_id={$upload->gid}&server={$upload->server}&photos_list={$upload->photos_list}&hash={$upload->hash}");

        return $save->response[0]->id;

    }
    public function uploadImages($aid, $gid, $images = array(), $text) {



        $text = str_replace(' ', '%20', $text);

        if(sizeof($images)>0){
            $counter = '1';
            $data = array();
            foreach($images as $image){
                $data["file".$counter] = '@'.$image;
                $counter++;
            }
            $server = $this->api("photos.getUploadServer","album_id=$aid&group_id=$gid");

            $res = $this->curlPost($server->response->upload_url, $data);
            $upload = json_decode($res);
            $save = $this->api("photos.save", "caption=$text&album_id={$upload->aid}&group_id={$upload->gid}&server={$upload->server}&photos_list={$upload->photos_list}&hash={$upload->hash}");
            return $save->response;
        }
        return false;
    }

    public function saveImg($url) {
        $upload_dir = $this->imagePath;
        $name = 'image.jpg';
        $file = file_get_contents($url);
        $openedfile = fopen($upload_dir.$name, "w");
        fwrite($openedfile, $file);
        fclose($openedfile);

        return $upload_dir.$name;
    }


    private function curlPost($url, $data=array()){
        try{
            if ( ! isset($url))
            {
                return false;
            }

            $ch = curl_init();
            //curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            if (count($data) > 0)
            {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            $response = curl_exec($ch);
            if (!$response){
                throw new Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);
            return $response;
        }
        catch(Exception $e){
            var_dump($e->getMessage());
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
    }
}
?>
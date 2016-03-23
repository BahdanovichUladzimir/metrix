<?php

class m151026_172835_add_banners_config extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('BANNERS_MODULE.BANNER_ALLOWED_IMAGES_FILE_TYPES', 'jpg, jpeg, png, gif', 'jpg, jpeg, png, gif', 'Banner allowed file types', 'string');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_URL', '/images/empty/notfound.png', '/images/empty/notfound.png', 'Banner image empty URL', 'string');
		INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES ('BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_PATH', '/var/www/all4holidays/protected/images/empty/notfound.png', '/var/www/all4holidays/protected/images/empty/notfound.png', 'Banner image empty path', 'string');
		");
    }

    public function safeDown()
    {
        $this->execute("
        DELETE FROM `Config` WHERE `param`='BANNERS_MODULE.BANNER_ALLOWED_IMAGES_FILE_TYPES';
        DELETE FROM `Config` WHERE `param`='BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_URL';
        DELETE FROM `Config` WHERE `param`='BANNERS_MODULE.BANNER_ORIGINAL_IMG_EMPTY_PATH';
        ");
    }
}
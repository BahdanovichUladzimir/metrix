<?php

class m150418_164129_add_avatar_configs extends CDbMigration
{
    public function up()
    {
        $this->execute("
            INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES
                ('USER_MODULE.AVATAR_LARGE_THUMB_WIDTH', '1000', '1000', 'Big thumb size', 'integer'),
                ('USER_MODULE.AVATAR_LARGE_THUMB_HEIGHT', '800', '800', 'Large thumb height', 'integer'),
                ('USER_MODULE.AVATAR_MEDIUM_THUMB_WIDTH', '500', '500', 'Medium thumb width', 'integer'),
                ('USER_MODULE.AVATAR_MEDIUM_THUMB_HEIGHT', '400', '400', 'Medium thumb height', 'integer'),
                ('USER_MODULE.AVATAR_SMALL_THUMB_HEIGHT', '100', '100', 'Small thumb height', 'integer'),
                ('USER_MODULE.AVATAR_SMALL_THUMB_WIDTH', '100', '100', 'Small thumb width', 'integer'),

                ('USER_MODULE.AVATAR_SMALL_THUMB_PREFIX', 'small_', 'small_', 'Small thumb prefix', 'string'),
                ('USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX', 'medium_', 'medium_', 'Medium thumb prefix', 'string'),
                ('USER_MODULE.AVATAR_LARGE_THUMB_PREFIX', 'large_', 'large_', 'Large thumb prefix', 'string'),

                ('USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_URL', '/images/empty/largeThumbEmpty.png', '/images/empty/largeThumbEmpty.png', 'Avatar large thumb empty image url', 'string'),
                ('USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_URL', '/images/empty/mediumThumbEmpty.png', '/images/empty/mediumThumbEmpty.png', 'Avatar medium thumb empty image url', 'string'),
                ('USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_URL', '/images/empty/smallThumbEmpty.png', '/images/empty/smallThumbEmpty.png', 'Avatar small thumb empty image url', 'string'),
                ('USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', 'Avatar large thumb empty image path', 'string'),
                ('USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', 'Avatar medium thumb empty image path', 'string'),
                ('USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', 'Avatar small thumb empty image path', 'string'),
                ('USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_URL', '/images/empty/notfound.png', '/yiiimages/empty/notfound.png', 'Avatar empty original image url', 'string'),
                ('USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', 'Avatar empty original image path', 'string'),
                ('USER_MODULE.AVATAR_ALLOWED_IMAGES_FILE_TYPES', 'jpg, jpeg, png, gif', 'jpg, jpeg, png, gif', 'Allowed uploads images file types', 'string');
		");
    }

    public function down()
    {
        echo "Эту миграцию нельзя откатить.\n";
        return false;
    }
}
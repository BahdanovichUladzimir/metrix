<?php

class m150305_144035_insert_dealsCategories_images_config extends CDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES
                ('DEALS_MODULE.CATEGORY_LARGE_THUMB_WIDTH', '1000', '1000', 'Big thumb size', 'integer'),
                ('DEALS_MODULE.CATEGORY_LARGE_THUMB_HEIGHT', '800', '800', 'Large thumb height', 'integer'),
                ('DEALS_MODULE.CATEGORY_MEDIUM_THUMB_WIDTH', '500', '500', 'Medium thumb width', 'integer'),
                ('DEALS_MODULE.CATEGORY_MEDIUM_THUMB_HEIGHT', '400', '400', 'Medium thumb height', 'integer'),
                ('DEALS_MODULE.CATEGORY_SMALL_THUMB_HEIGHT', '100', '100', 'Small thumb height', 'integer'),
                ('DEALS_MODULE.CATEGORY_SMALL_THUMB_WIDTH', '100', '100', 'Small thumb width', 'integer'),
                ('DEALS_MODULE.CATEGORY_LARGE_THUMB_EMPTY_URL', '/images/empty/largeThumbEmpty.png', '/images/empty/largeThumbEmpty.png', 'Category large thumb empty image url', 'string'),
                ('DEALS_MODULE.CATEGORY_MEDIUM_THUMB_EMPTY_URL', '/images/empty/mediumThumbEmpty.png', '/images/empty/mediumThumbEmpty.png', 'Category medium thumb empty image url', 'string'),
                ('DEALS_MODULE.CATEGORY_SMALL_THUMB_EMPTY_URL', '/images/empty/smallThumbEmpty.png', '/images/empty/smallThumbEmpty.png', 'Category small thumb empty image url', 'string'),
                ('DEALS_MODULE.CATEGORY_LARGE_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', 'Category large thumb empty image path', 'string'),
                ('DEALS_MODULE.CATEGORY_MEDIUM_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', 'Category medium thumb empty image path', 'string'),
                ('DEALS_MODULE.CATEGORY_SMALL_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', 'Category small thumb empty image path', 'string'),
                ('DEALS_MODULE.CATEGORY_ORIGINAL_IMG_EMPTY_URL', '/images/empty/notfound.png', '/images/empty/notfound.png', 'Category empty original image url', 'string'),
                ('DEALS_MODULE.CATEGORY_ORIGINAL_IMG_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', 'Category empty original image path', 'string');
		");
	}

	public function down()
	{
		echo "m150305_144035_insert_dealsCategories_images_config does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
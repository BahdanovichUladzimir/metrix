<?php

class m150222_164911_add_empty_images_configs extends CDbMigration
{
	public function up()
	{
		$this->execute("
			INSERT INTO `dev_dont_stop`.`Config` (`param`, `value`, `default`, `label`, `type`)
			VALUES
			('DEALS_MODULE.LARGE_THUMB_EMPTY_URL', '/images/empty/largeThumbEmpty.png', '/images/empty/largeThumbEmpty.png', 'Large thumb empty image url', 'string'),
			('DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL', '/images/empty/mediumThumbEmpty.png', '/images/empty/mediumThumbEmpty.png', 'Medium thumb empty image url', 'string'),
			('DEALS_MODULE.SMALL_THUMB_EMPTY_URL', '/images/empty/smallThumbEmpty.png', '/images/empty/smallThumbEmpty.png', 'Small thumb empty image url', 'string'),
			('DEALS_MODULE.LARGE_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/largeThumbEmpty.png', 'Large thumb empty image path', 'string'),
			('DEALS_MODULE.MEDIUM_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/mediumThumbEmpty.png', 'Medium thumb empty image path', 'string'),
			('DEALS_MODULE.SMALL_THUMB_EMPTY_PATH', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', '/var/www/dev.all4holidays/protected/images/empty/smallThumbEmpty.png', 'Small thumb empty image path', 'string'),
			('DEALS_MODULE.EMPTY_ORIGINAL_IMG_URL', '/images/empty/notfound.png', '/images/empty/notfound.png', 'Empty original image url', 'string'),
			('DEALS_MODULE.EMPTY_ORIGINAL_IMG_PATH', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', '/var/www/dev.all4holidays/protected/images/empty/notfound.png', 'Empty original image path', 'string');
		");
	}

	public function down()
	{
		$this->execute("
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.LARGE_THUMB_EMPTY_URL';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.SMALL_THUMB_EMPTY_URL';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.LARGE_THUMB_EMPTY_PATH';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.MEDIUM_THUMB_EMPTY_PATH';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.SMALL_THUMB_EMPTY_PATH';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.EMPTY_ORIGINAL_IMG_URL';
			DELETE FROM `dev_dont_stop`.`Config` WHERE  `param`='DEALS_MODULE.EMPTY_ORIGINAL_IMG_PATH';
			");
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
<?php

class m150216_091259_add_thumbs_params_to_config_table extends CDbMigration
{
	public function up()
	{
		$this->execute("
			INSERT IGNORE INTO `Config` (`param`, `value`, `default`, `label`, `type`) VALUES
			('DEALS_MODULE.LARGE_THUMB_WIDTH', '1000', '1000', 'Large thumb width', 'integer'),
			('DEALS_MODULE.LARGE_THUMB_HEIGHT', '800', '800', 'Large thumb height', 'integer'),
			('DEALS_MODULE.MEDIUM_THUMB_WIDTH', '500', '500', 'Medium thumb height', 'integer'),
			('DEALS_MODULE.MEDIUM_THUMB_HEIGHT', '400', '400', 'Medium thumb height', 'integer'),
			('DEALS_MODULE.SMALL_THUMB_WIDTH', '100', '100', 'Small thumb height', 'integer'),
			('DEALS_MODULE.SMALL_THUMB_HEIGHT', '100', '100', 'Small thumb height', 'integer'),
			('DEALS_MODULE.SMALL_THUMB_PREFIX', 'small_', 'small_', 'Small thumb prefix', 'string'),
			('DEALS_MODULE.MEDIUM_THUMB_PREFIX', 'medium_', 'medium_', 'Medium thumb prefix', 'string'),
			('DEALS_MODULE.LARGE_THUMB_PREFIX', 'large_', 'large_', 'Large thumb prefix', 'string');
		");
	}

	public function down()
	{
		echo "m150216_091259_add_thumbs_params_to_config_table does not support migration down.\n";
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
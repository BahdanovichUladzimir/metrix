<?php

class m150221_141459_add_dir_path_and_dir_url_columns_to_deals_videos_table extends CDbMigration
{
	public function up()
	{
		$this->execute("
			ALTER TABLE `DealsVideos`
				ADD COLUMN `dir_path` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Путь к директории видео' AFTER `url`,
				ADD COLUMN `dir_url` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Url директории видео' AFTER `dir_path`;
		");
	}

	public function down()
	{
		$this->execute("
			ALTER TABLE `DealsVideos`
				DROP COLUMN `dir_path`,
				DROP COLUMN `dir_url`;
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
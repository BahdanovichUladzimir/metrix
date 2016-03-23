<?php

class m150216_141200_add_full_path_column_to_dealsImages_table extends CDbMigration
{
	public function up()
	{
		$this->execute("
		ALTER TABLE `DealsImages`
			ADD COLUMN `dir_path` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Путь к директории изображения' AFTER `path`;
		");
		$this->execute("
		ALTER TABLE `DealsImages`
			ADD COLUMN `dir_url` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Url директории изображения' AFTER `dir_path`;
		");
	}

	public function down()
	{
		$this->execute("
		ALTER TABLE `DealsImages`
			DROP COLUMN `dir_path`;
		");
		$this->execute("
		ALTER TABLE `DealsImages`
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
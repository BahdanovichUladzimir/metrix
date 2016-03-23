<?php

class m150209_093942_add_column_default_language_to_table_countries extends CDbMigration
{
	public function up()
	{

		$this->execute("ALTER TABLE `Countries` ADD COLUMN `default_language` VARCHAR(10) NOT NULL DEFAULT 'en' COMMENT 'Default language' AFTER `name`;");
	}

	public function down()
	{
		$this->execute("
			ALTER TABLE `Countries` DROP COLUMN `default_language`;
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